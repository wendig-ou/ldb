<?php 
  require_once APPPATH.'controllers/Admin_Controller.php';
  require_once APPPATH.'controllers/Resource_Controller.php';

  class Institutions extends IGB_Controller {
    use Resource_Controller;

    public function __construct() {
      parent::__construct();

      if ($this->router->fetch_method() != 'by_id') {
        if (!$this->has_role(['admin', 'library'])) {
          $this->permission_denied();
        }
      }

      $this->resource = 'institution';
      $this->resources = 'institutions';

      $this->data['title'] = lang('igb_'.$this->resources);
      $this->load->model($this->resources.'_model', 'model');
    }

    private function attribs($without_null = TRUE) {
      $data = array(
        'institut' => $this->input->post('name')
      );

      if ($without_null)
        $data = $this->without_null($data);

      return $data;
    }

    public function delete($id) {
      if ($this->model->usage_count($id) > 0) {
        $message = sprintf(lang('igb_error_institution_in_use'), $id);
        $this->flash($message, 'error');
      } else {
        $this->model->delete($id);
        $this->flash(lang('igb_notice_deleted'));
      }
      redirect($this->agent->referrer());
    }

    protected function configure_validation() {
      parent::configure_validation();

      $this->form_validation->set_rules(
        array(
          array(
            'field' => 'name',
            'label' => 'lang:igb_field_name',
            'rules' => 'required|callback_is_unique[igb_ldb_institutions.institut.iid]'
          )
        )
      );
    }
  }
?>