<?php 
  class Migrate extends IGB_Controller {
    public function index($updown) {
      $this->load->library('migration');

      if ($updown == 'up') {
        echo "migrating up ...\n";
        $result = $this->migration->latest();
      } else {
        echo "migrating down ...\n";
        $result = $this->migration->version('0');
      }

      if ($result === FALSE) {
        $error = $this->migration->error_string();
        echo "migrations failed: ".$error."\n";
        exit(1);
      } else {
        echo "migrations successfull\n";
        exit(0);
      }
    }
  }
?>