<?php 
  require_once APPPATH.'controllers/Admin_Controller.php';
  require_once APPPATH.'controllers/Resource_Controller.php';

  class Users extends Admin_Controller
  {
    use Resource_Controller;

    public function __construct()
    {
      parent::__construct();

      $this->resource = 'user';
      $this->resources = 'users';

      $this->data['title'] = lang('igb_'.$this->resources);
      $this->data['roles'] = $this->roles();
      $this->data['departments'] = $this->departments();
      $this->load->model($this->resources.'_model', 'model');
    }

    private function attribs($without_null = TRUE)
    {
      $data = array(
        'uname' => $this->input->post('uname'),
        'role' => $this->input->post('role'),
        'comment' => $this->input->post('comment'),
        'dpmt' => $this->input->post('dpmt')
      );

      if ($pw = $this->input->post('pw')) {
        $data['salt'] = $this->model->generate_salt();
        $data['pw'] = $this->model->hash($pw, $data['salt']);
      }

      if ($without_null)
        return $this->without_null($data);
      else
        return $data;
    }

    protected function configure_validation()
    {
      parent::configure_validation();

      $this->form_validation->set_rules(
        array(
          array(
            'field' => 'uname',
            'label' => 'lang:igb_field_username',
            'rules' => 'required|callback_is_unique[passwd.uname.uid]'
          ),
          array(
            'field' => 'role',
            'label' => 'lang:igb_field_role',
            'rules' => 'callback_is_role'
          ),
          array(
            'field' => 'password_confirmation',
            'label' => 'lang:igb_field_password_confirmation',
            'rules' => 'min_length[6]|callback_matches_password'
          )
        )
      );
    }

    public function matches_password($value)
    {
      $password = $this->input->post('pw');
      return ($password == $value);
    }

    // public function sync() {
    //   $ldap = new IGB_LDAP();
    //   $ldap->sync_users();
    // }
  }
?>