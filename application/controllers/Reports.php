<?php 
  require_once APPPATH.'controllers/Admin_Controller.php';

  class Reports extends IGB_Controller {
    public function __construct() {
      parent::__construct();

      $this->data['title'] = lang('igb_reports');

      if (!$this->has_role(['admin', 'library', 'data_collector'])) {
        $this->permission_denied();
      }
    }

    public function index() {
      $dir = '../reports';

      $this->data['reports'] = [];
      foreach (scandir($dir) as $candidate) {
        $path = $dir.'/'.$candidate;

        if (is_file($path) && preg_match('/\.sql$/i', $path)) {
          $this->data['reports'][$candidate] = file_get_contents($path);
        }
      }

      $this->template('reports/index');
    }

    public function run() {
      $name = $this->input->get('name');
      $format = $this->input->get('format');

      if (preg_match('/\//', $name)) {
        $this->flash(lang('igb_error_no_slash_allowed_in_name'));
        redirect('/reports');
      } else {
        $query = file_get_contents('../reports/'.$name);
        $records = $this->db->query($query)->result_array();
        $any_results = sizeof($records) > 0;
        $massive_resultset = $any_results && count($records[0]) > 6;

        if ($format == 'csv') {
          $output = "";
          if ($any_results) {
            $output .= $this->to_csv(array_keys($records[0]));
            foreach ($records as $record) {
              $output .= $this->to_csv(array_values($record));
            }
          }
          $filename = strftime('%Y-%m-%d-%H-%M-%S').'_'.$name.'.csv';
          $this->output
            ->set_content_type('text/csv', 'utf-8')
            ->set_header('content-disposition: attachment; filename='.$filename)
            ->set_output($output);
        } else {
          $this->data['name'] = $name;
          $this->data['records'] = $records;
          $this->data['any_results'] = $any_results;
          $this->data['massive_resultset'] = $massive_resultset;
          $this->template('reports/run');
        }
      }
    }
  }
?>