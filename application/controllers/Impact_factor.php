<?php 
  require_once APPPATH.'controllers/Admin_Controller.php';

  class Impact_factor extends Admin_Controller
  {

    public function __construct()
    {
      parent::__construct();

      $this->data['title'] = lang('igb_impact_factor_import');

      $this->load->model('Publications_model', 'publications_model');
      $this->load->model('Periodicals_model', 'periodicals_model');
    }

    public function index()
    {
      $this->configure_validation(); # just to make some helpers work
      $this->template('impact_factor/form');
    }

    public function preflight()
    {
      $this->configure_validation(); # just to make some helpers work
      $this->data['year'] = $this->input->post('year');
      $this->data['mapping'] = $this->input->post('mapping');
      $this->data['records'] = $this->parse(
        $this->data['year'],
        $this->data['mapping']
      );
      $this->template('impact_factor/preflight');
    }

    public function commit()
    {
      $year = $this->input->post('year');
      $mapping = $this->input->post('mapping');
      $mappings = $this->parse($year, $mapping);
      $this->data['report'] = [];

      foreach ($mappings as $record) {
        if ($record['periodical']) {
          foreach ($record['publications'] as $pub) {
            $this->publications_model->update($pub['pid'], ['impactf' => $record['impact_factor']]);
            array_push($this->data['report'], [
              'pid' => $pub['pid'],
              'impact_factor' => $record['impact_factor']
            ]);
          }
        }
      }

      $this->template('impact_factor/commit');
    }

    private function parse($year, $data)
    {
      $records = [];

      $mapping = preg_split('/\n/', $data);
      foreach ($mapping as $line) {
        if ($line) {
          list($periodical_name, $impact_factor) = preg_split('/\s*[\t\|]+\s*/', $line);
          $pubs = [];
          $periodical = NULL;
          if ($periodical = $this->periodicals_model->by_name($periodical_name)) {
            $query = $this->publications_model
              ->base_query()
              ->where('pname_id', $periodical['pid'])
              ->where('fdate', $year);
            foreach ($query->get()->result_array() as $publication) {
              $pubs[] = $publication;
            }
          }

          $records[] = [
            'periodical_name' => $periodical_name,
            'publications' => $pubs,
            'periodical' => $periodical,
            'impact_factor' => $impact_factor
          ];
        }
      }

      error_log(print_r($records, TRUE));

      return $records;
    }

  }
?>
