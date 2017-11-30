<?php 
  class Auth extends IGB_Controller {
    public function __construct() {
      parent::__construct();

      $this->data['title'] = lang('igb_authentication');
    }

    public function new() {
      $this->load->library('form_validation');
      $this->configure_validation();

      $this->data['no_form'] = $this->input->get('noform');

      if ($this->form_validation->run() == FALSE) {
        $this->output->set_status_header(401);
        $this->template('auth/form', $this->data);
      } else {
        // ensure department
        $u = $this->current_user();
        if (!isset($u['dpmt']) || $u['dpmt'] == '') {
          error_log(print_r($u, TRUE));
          unset($_SESSION['username']);
          unset($this->user);

          $msg = lang('igb_error_no_department');
          $this->flash($msg, 'error');
          redirect('/auth/new?noform=true');
        } else {
          $msg = sprintf(lang('igb_notice_sign_in'), $this->session->username);
          $this->flash($msg);

          if ($this->input->post('return_to')) {
            redirect($this->input->post('return_to'));
          } else {
            redirect('/');
          }
        }
      }
    }

    public function delete() {
      unset($_SESSION['username']);
      unset($this->user);

      $msg = lang('igb_notice_sign_out');
      $this->flash($msg);
      redirect('/');
    }

    protected function configure_validation() {
      $this->form_validation->set_error_delimiters(
        '<p class="alert alert-danger">', '</p>'
      );
      $this->form_validation->set_rules(
        array(
          array(
            'field' => 'username',
            'label' => 'lang:igb_field_username',
            'rules' => 'required'
          ),
          array(
            'field' => 'password',
            'label' => 'lang:igb_field_password',
            'rules' => 'required|callback_authenticate'
          )
        )
      );
    }

    public function authenticate($password) {
      $this->load->library('IGB_LDAP');

      $username = $this->igb_ldap->authenticate($this->input->post('username'), $password);
      
      if ($username) {
        $this->session->username = $username;
        return TRUE;
      } else {
        $this->form_validation->set_message(
          'authenticate',
          lang('igb_form_validation_password')
        );
        return FALSE;
      }
    }
  }
?>