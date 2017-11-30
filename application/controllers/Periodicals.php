<?php 
  require_once APPPATH.'controllers/Admin_Controller.php';
  require_once APPPATH.'controllers/Resource_Controller.php';

  class Periodicals extends IGB_Controller {
    use Resource_Controller;

    public function __construct() {
      parent::__construct();

      if ($this->router->fetch_method() != 'by_id') {
        if (!$this->has_role(['admin', 'library'])) {
          $this->permission_denied();
        }
      }

      $this->resource = 'periodical';
      $this->resources = 'periodicals';

      $this->data['title'] = lang('igb_'.$this->resources);
      $this->load->model($this->resources.'_model', 'model');
    }

    public function delete($id) {
      if ($this->model->usage_count($id) > 0) {
        $message = sprintf(lang('igb_error_periodical_in_use'), $id);
        $this->flash($message, 'error');
      } else {
        $this->model->delete($id);
        $this->flash(lang('igb_notice_deleted'));
      }
      redirect($this->agent->referrer());
    }

    private function attribs($without_null = TRUE) {
      $data = array(
        'pname' => $this->input->post('name')
      );

      if ($without_null)
        $data = $this->without_null($data);
      
      return $data;
    }

    protected function configure_validation() {
      parent::configure_validation();

      $this->form_validation->set_rules(
        array(
          array(
            'field' => 'name',
            'label' => 'lang:igb_field_name',
            'rules' => 'required|callback_is_unique[periodicals.pname.pid]'
          )
        )
      );
    }
  }
?>