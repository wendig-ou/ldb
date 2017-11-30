<?php
  trait Resource_Controller {
    public function index() {
      $this->load->library('pagination');
      $this->configure_validation();

      $page = $this->input->get('page') ?? 1;
      $per_page = $this->input->get('per_page') ?? 20;

      $options = [
        'sort_column' => $this->input->get('sort-column'),
        'sort_direction' => $this->input->get('sort-direction'),
        'terms' => $this->input->get('terms')
      ];
      $this->data[$this->resources] = $this->model->get_all($page, $per_page, $options);
      $this->data['total'] = $this->model->count($options);

      $this->template($this->resources.'/index');
    }

    public function by_id($id) {
      $this->data['id'] = $id;
      $this->data[$this->resource] = $this->model->get($id);
      $this->output
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($this->data[$this->resource]));
    }

    public function new() {
      $this->configure_validation();

      $this->data[$this->resource] = $this->attribs(FALSE);

      if ($this->form_validation->run() === FALSE) {
        $this->template($this->resources.'/form');
      } else {
        $this->model->create($this->attribs());
        $this->flash(lang('igb_notice_created'));

        if ($url = $this->input->post('return_to')) {
          redirect($url);
        } else {
          redirect('/'.$this->resources);
        }
      }
    }

    public function edit($id) {
      $this->configure_validation();

      $this->data['id'] = $id;
      $this->data[$this->resource] = $this->model->get($id);

      if ($this->form_validation->run() === FALSE) {
        $this->template($this->resources.'/form');
      } else {
        $this->model->update($id, $this->attribs());
        $this->flash(lang('igb_notice_updated'));

        if ($url = $this->input->post('return_to')) {
          redirect($url);
        } else {
          redirect('/'.$this->resources);
        }
      }
    }

    public function delete($id) {
      $this->model->delete($id);
      $this->flash(lang('igb_notice_deleted'));
      redirect($this->agent->referrer());
    }

    private function attribs($without_null = TRUE) {
      return array();
    }

    public function required_autocomplete($value, $args)
    {
      list($field) = preg_split('/\./', $args);

      if (! $value) {
        if (! isset($this->data[$this->resource][$field]) || ! $this->data[$this->resource][$field]) {
          return FALSE;
        }
      }

      return TRUE;
    }
  }
?>