<?php 
  class Autocomplete extends IGB_Controller {
    public function __construct() {
      parent::__construct();
    }

    public function people() {
      $this->load->model('People_model', 'model');
      $terms = $this->input->get('terms');
      $this->data['records'] = $this->model->autocomplete($terms);
      $this->output
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($this->data['records']));
    }

    public function periodicals() {
      $this->load->model('Periodicals_model', 'model');
      $terms = $this->input->get('terms');
      $this->data['records'] = $this->model->autocomplete($terms);
      $this->output
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($this->data['records']));
    }

    public function institutions() {
      $this->load->model('Institutions_model', 'model');
      $terms = $this->input->get('terms');
      $this->data['records'] = $this->model->autocomplete($terms);
      $this->output
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($this->data['records']));
    }
  }
?>