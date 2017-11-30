<?php 
  require_once APPPATH.'controllers/Admin_Controller.php';

  class Ris extends Admin_Controller
  {

    public function __construct()
    {
      parent::__construct();
      $this->load->library('IGB_RIS');

      $this->data['title'] = lang('igb_ris_import');
    }

    public function index()
    {
      $this->configure_validation(); # just to make some helpers work
      $this->template('ris/form');
    }

    public function preflight()
    {
      $this->configure_validation(); # just to make some helpers work

      $this->load->library('upload', [
        'upload_path' => '/tmp',
        'allowed_types' => 'ris|RIS'
      ]);

      if (! $this->upload->do_upload('file')) {
        // error_log(print_r($this->upload->data(), TRUE));
        $this->data['errors'] = $this->upload->display_errors('<p class="alert alert-danger">', '</p>');
        $this->data['records'] = [];
        $this->template('ris/form');
      } else {
        // error_log(print_r($this->upload->data(), TRUE));
        $file = $this->upload->data()['full_path'];
        $this->data['file'] = $this->upload->data()['file_name'];
        $this->data['records'] = $this->igb_ris->preflight($file, $this->current_user());
        $this->template('ris/preflight');
      }

    }

    public function commit()
    {
      $file_name = preg_replace('/\//', '', $this->input->get('file'));
      $path = '/tmp/'.$file_name;
      $this->data['report'] = $this->igb_ris->commit($path, $this->current_user());

      $this->template('ris/commit');
    }

  }
?>
