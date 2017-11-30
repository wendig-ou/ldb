<?php 
  class Publications_people_model extends CI_Model {
    public function by_id($ids) {
      $query = $this->db
        ->select('a.*, p.Person as label, p.lpid as value')
        ->where_in('a.laid', $ids)
        ->order_by('a.ord')
        ->from('igb_ldb_lom_authors a')
        ->join('igb_ldb_lom_persons p', 'p.lpid = a.lpid', 'left')
        ->get();

      return $query->result_array();
    }

    public function by_publication_id($id, $type = 'a') {
      $query = $this->db
        ->where('publication_id', $id)
        ->where('type', $type)
        ->order_by('ord')
        ->get('igb_ldb_lom_authors');
      return $query->result_array();
    }

    public function update($publication_id, $data, $type = 'a') {
      $this->db->trans_start();

      $keep_ids = array();
      foreach ($data as $i => $record) {
        list($link_id, $person_id, $igb) = $record;
        if (isset($link_id)) {
          $this->db
            ->where('laid', $link_id)
            ->where('type', $type)
            ->set('igb', $igb)
            ->set('ord', $i)
            ->update('igb_ldb_lom_authors');
          array_push($keep_ids, $link_id);
        } else {
          if (!is_numeric($person_id)) {
            $this->load->model('People_model', 'people_model');

            $persion_id = NULL;
            if ($existing = $this->people_model->by_name($person_id)) {
              # the user has filled in an existing name by hand
              $person_id = $existing['lpid'];
            } else {
              $person_id = $this->people_model->create(['Person' => $person_id]);
            }
          }
          
          $this->db->insert('igb_ldb_lom_authors', array(
            'lpid' => $person_id,
            'igb' => $igb,
            'ord' => $i,
            'publication_id' => $publication_id,
            'type' => $type
          ));
          array_push($keep_ids, $this->db->insert_id());
        }
      }

      $query = $this->db
        ->where('publication_id', $publication_id)
        ->where('type', $type);
      if (count($keep_ids) > 0)
        $query = $query->where_not_in('laid', $keep_ids);
      $query->delete('igb_ldb_lom_authors');

      $this->db->trans_complete();
    }

    public function for_publications($publications, $type = 'a')
    {
      $results = [];
      if (empty($publications)) {return $results;}

      foreach ($publications as $p) {$results[$p['pid']] = [];}
      $query = $this->db
        ->select('a.publication_id, p.Person, a.igb')
        ->from('igb_ldb_lom_authors AS a')
        ->join('igb_ldb_lom_persons p', 'p.lpid = a.lpid', 'left')
        ->where_in('a.publication_id', array_keys($results))
        ->where('a.type', $type)
        ->order_by('a.ord')
        ->get();
      $records = $query->result_array();

      foreach ($records as $record) {
        array_push($results[$record['publication_id']], $record);
      }
      return $results;
    }
  }
?>