<?php 
  class IGB_Controller extends CI_Controller {

    public function __construct()
    {
      parent::__construct();

      $this->lang->load('general', 'english');
      $this->data['translations'] = $this->lang->load(
        'general', 'english', TRUE
      );
      $this->data['current_user'] = $this->current_user();
      $this->data['referrer'] = $this->agent->referrer();
      $this->ensure_logged_in();
    }

    private function ensure_logged_in()
    {
      if (! $this->input->is_cli_request()) {
        if (!$this->current_user() && uri_string() != 'auth/new') {
          if (current_url() != base_url()) {
            $return_to = urlencode(current_url());
            redirect('/auth/new?return_to='.$return_to);
          } else {
            redirect('/auth/new');
          }
        }
      }
    }

    protected function template($template_name, $vars = NULL)
    {
      $vars = $vars ?? $this->data;

      $this->load->view('templates/header', $vars);
      $this->load->view($template_name, $vars);
      $this->load->view('templates/footer', $vars);
    }

    protected function flash($message, $type = 'notice')
    {
      $this->session->set_flashdata($type, $message);
    }

    protected function configure_validation()
    {
      $this->load->library('form_validation');
      $this->form_validation->set_error_delimiters(
        '<p class="alert alert-danger">', '</p>'
      );
    }

    public function roles()
    {
      return array('admin', 'library', 'data_collector', 'proofreader', 'user');
    }

    public function departments()
    {
      return array('1', '2', '3', '4', '5', '6', 'D', 'B');
    }

    public function is_role($value)
    {
      return in_array($value, $this->roles());
    }

    public function is_department($value)
    {
      return in_array($value, $this->departments());
    }

    public function is_department_list($value)
    {
      // error_log(print_r($value, TRUE));
      foreach (preg_split('/,/', $value) as $candidate) {
        if (!$this->is_department($candidate)) {
          return false;
        }
      }
      return true;
    }

    public function is_unique($value, $args)
    {
      list($table, $column, $id_column) = preg_split('/\./', $args);
      if (! $id_column) {
        $id_column = 'id';
      }

      if ($this->input->post('id')) {
        $id = $this->input->post('id');
      } else {
        $id = '';
      }

      $this->db->where($column, $value);
      if ($id) {
        $this->db->where_not_in($id_column, $id);
      }
      $result = $this->db->get($table)->num_rows();
      return $result == 0;
    }

    public function is_date($value) {
      return($value == '' || strptime($value, '%Y%m%d') != FALSE);
    }

    public function without_null($array)
    {
      foreach($array as $key => $value) {
        if(is_null($value) || $value == '')
          unset($array[$key]);
      }

      return $array;
    }

    public function current_user()
    {
      if (! isset($this->user) && isset($this->session->username)) {
        $this->load->model('users_model');
        $this->user = $this->users_model->get_by_username(
          $this->session->username
        );
      }

      if (isset($this->user)) {
        return $this->user;
      } else 
        return NULL;
    }

    public function current_role()
    {
      if ($this->current_user()) {
        return $this->current_user()['role'];
      } else {
        return NULL;
      }
    }

    public function has_role($roles = ['admin', 'library'])
    {
      return in_array($this->current_role(), $roles);
    }

    public function permission_denied()
    {
      show_error(
        ucfirst(lang('igb_error_permission_denied')), 403,
        ucfirst(lang('igb_error_heading'))
      );
    }

    public function not_found()
    {
      show_error(
        ucfirst(lang('igb_error_not_found')), 404,
        ucfirst(lang('igb_error_heading'))
      );
    }

    function to_csv($fields, $delimiter = ",", $enclosure = '"', $escape_char = "\\")
    {
      $buffer = fopen('php://temp', 'r+');
      fputcsv($buffer, $fields, $delimiter, $enclosure, $escape_char);
      rewind($buffer);
      $csv = fgets($buffer);
      fclose($buffer);
      return $csv;
    }

  }
?>