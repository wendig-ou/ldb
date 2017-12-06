<?php 
  class IGB_RIS
  {
    public function __construct()
    {
      $this->CI = &get_instance();
      $this->CI->load->model('People_model', 'people_model');
      $this->CI->load->model('Publications_model', 'publications_model');
      $this->CI->load->model('Periodicals_model', 'periodicals_model');
      $this->CI->load->model('publications_people_model', 'authors_model');
      $this->CI->load->model('users_model', 'users_model');
    }

    public function commit($file, $user)
    {
      $records = $this->preflight($file, $user);
      $report = [];

      # create all required people records and redo the preflight
      $created = [];
      foreach ($records as $record) {
        foreach ($record['people'] as $i => $person) {
          if (!is_numeric($person[1])) {
            $name = $person[1];
            $id = 0;
            if (isset($created[$person[1]])) {
              $id = $created[$person[1]];
            } else {
              $id = $this->CI->people_model->create(['Person' => $person[1]]);
              $created[$name] = $id;
            }
          }
        }
      }
      $records = $this->preflight($file, $user);

      foreach ($records as $record) {
        // error_log(print_r($record, TRUE));

        $id = $record['existing'];
        if (!$id) {
          $id = $this->CI->publications_model->create($record['record']);
          $report[]= [$id, 'new'];
        }
        $this->CI->authors_model->update($id, $record['people'], 'a');
      }

      return $report;
    }

    public function preflight($file, $user)
    {
      $data = $this->parse($file);

      $results = [];
      foreach ($data as $raw) {
        $result= [
          'existing' => $this->exists($raw['N1']),
          'record' => [
            'ris_id' => $raw['N1'],
            'klr_tow' => $this->type($raw),
            'uid' => $user['uid'],
            'dpmt' => $user['dpmt'],
            'ct' => FALSE,
            'title' => $this->read($raw, 'TI'),
            'organization' => $this->read($raw, 'T3'),
            'notes' => $this->read($raw, 'U1'),
            'fdate' => $this->read($raw, 'PY'),
            // 'end_fdate' => '-',
            'doi' => $this->read($raw, 'DO'),
            'epage' => $this->read($raw, 'SP'),
            'place' => $this->read($raw, 'CY'),
            'open_access' => $this->open_access($raw)
          ]
        ];

        $result = $this->add_book_or_periodical($result, $raw);
        $result = $this->add_people($result, $raw);

        $results[] = $result;
      }

      // error_log(print_r($results, TRUE));
      return $results;
    }

    public function parse($file)
    {
      $array_keys = ['AU', 'U3', 'UR'];

      $data = [];
      $current = FALSE;

      $encoding = mb_detect_encoding(file_get_contents($file), ['UTF-8', 'ISO-8859-1', 'ASCII']);

      $handle = fopen($file, 'r');
      while (($line = fgets($handle)) !== false) {
        $line = trim($line);

        if ($encoding != 'UTF-8') {
          $line = mb_convert_encoding($line, 'UTF-8', $encoding);
        }

        if (preg_match('/^\s*$/', $line)) {
          // empty line, ignore
        } elseif (preg_match('/^ER  /', $line)) {
          $data[] = $current;
          $current = ['TY' => $value];
          foreach ($array_keys as $k) {$current[$k] = [];}
        } else {
          list($key, $value) = explode('  - ', $line);

          if (in_array($key, $array_keys)) {
            $current[$key][] = $value;
          } else {
            $current[$key] = $value;
          }
        }
      }
      fclose($handle);

      // error_log(print_r($data, TRUE));
      return $data;
    }

    private function type($raw)
    {
      $mapping = [
        'Referierte Zeitschrift mit IF' => '01.01',
        'Referierte Zeitschrift' => '01.02',
        'Herausgeberschaft' => '01.03',
        'Autorenschaft international' => '01.04',
        'Buchbeitrag international' => '01.05',
        'Proceeding international' => '01.07',
        'Nichtreferierte Zeitschrift' => '01.10',
        'Buchbeitrag national' => '01.11',
        'Proceeding national' => '01.07',
        'Forschungsbericht' => '01.13',
        'Autorenschaft national' => '01.14',
        'Autorenschaft IGB Dossier' => '09.10',
        'Forschungsdaten' => '0. 15'
      ];

      $u2 = $this->read($raw, 'U2');
      if (isset($mapping[$u2])) {
        return $mapping[$u2];
      } else {
        return NULL;
      }
    }

    private function open_access($record)
    {
      foreach($record['U3'] as $u3) {
        if (preg_match('/^PD02/', $u3)) {
          return TRUE;
        }
      }

      return FALSE;
    }

    private function exists($ris_id)
    {
      $pub = $this->CI->publications_model->by_ris_id($ris_id);
      if ($pub) {
        return $pub['pid'];
      } else {
        return 0;
      }
    }

    private function add_book_or_periodical($record, $raw)
    {
      $v = $this->read($raw, 'T2');
      if (in_array($record['record']['klr_tow'], ['01.01', '01.02', '01.10', '01.15'])) {
        if ($periodical = $this->CI->periodicals_model->by_name($v)) {
          $record['record']['pname_id'] = $periodical['pid'];
          $record['record']['periodical_name'] = $periodical['pname'];
        } else {
          $record['record']['periodical_name'] = $v;
        }
      } else {
        $record['record']['booktitle'] = $v;
      }

      // error_log('---');
      // error_log(print_r($record, TRUE));
      // error_log(print_r($raw, TRUE));

      return $record;
    }

    private function add_people($record, $raw)
    {
      $record['people'] = [];

      foreach ($raw['AU'] as $a) {
        $a = preg_replace('/ \[[^\]]+\]$/', '', $a);
        if ($person = $this->CI->people_model->by_name($a)) {
          $record['people'][]= [NULL, $person['lpid'], $this->is_igb($a), $person['Person']];
        } else {
          $record['people'][]= [NULL, $a, $this->is_igb($a), $a];
        }
      }

      return $record;
    }

    private function is_igb($name)
    {
      $parts = preg_split('/\s*,\s*/', $name);
      // error_log($name);
      $no_comma = $parts[1].' '.$parts[0];
      $no_middle = preg_replace('/\s+[A-Z]\.\s+/', ' ', $no_comma);
      // error_log($no_comma);
      // error_log($no_middle);
      return(
        !!$this->CI->users_model->get_active_by_name($name) ||
        !!$this->CI->users_model->get_active_by_name($no_comma) ||
        !!$this->CI->users_model->get_active_by_name($no_middle)
      );
    }

    private function read($raw, $key)
    {
      return isset($raw[$key]) ? $raw[$key] : NULL;
    }
  }
?>