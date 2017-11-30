<?php 
  require_once APPPATH.'controllers/Admin_Controller.php';
  require_once APPPATH.'controllers/Resource_Controller.php';

  class People extends IGB_Controller {
    use Resource_Controller;

    public function __construct() {
      parent::__construct();

      if ($this->router->fetch_method() != 'by_id') {
        if (!$this->has_role(['admin', 'library'])) {
          $this->permission_denied();
        }
      }

      $this->resource = 'person';
      $this->resources = 'people';

      $this->data['title'] = lang('igb_people');
      $this->data['ref_nums'] = array(1, 2, 3, 4, 5, 6, 7);
      $this->load->model($this->resources.'_model', 'model');
    }

    public function by_id() {
      $ids = preg_split('/,/', $this->input->get('ids'));
      $data = $this->model->by_id($ids);

      $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($data));
    }

    public function delete($id) {
      if ($this->model->usage_count($id) > 0) {
        $message = sprintf(lang('igb_error_person_in_use'), $id);
        $this->flash($message, 'error');
      } else {
        $this->model->delete($id);
        $this->flash(lang('igb_notice_deleted'));
      }
      redirect($this->agent->referrer());
    }

    private function attribs($without_null = TRUE) {
      $data = array(
        'Person' => $this->input->post('Person')
      );

      foreach ($this->data['ref_nums'] as $rn) {
        $data['Verweisung'.$rn] = $this->input->post('reference_'.$rn);
      }

      if ($without_null)
        return $this->without_null($data);
      else
        return $data;
    }

    protected function configure_validation() {
      parent::configure_validation();

      $this->form_validation->set_rules(
        array(
          array(
            'field' => 'Person',
            'label' => 'lang:igb_field_name',
            'rules' => 'required|callback_is_unique[igb_ldb_lom_persons.Person.lpid]'
          )
        )
      );
    }
  }
?>