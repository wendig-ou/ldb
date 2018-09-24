<?php 
  require_once APPPATH.'controllers/Admin_Controller.php';
  require_once APPPATH.'controllers/Resource_Controller.php';

  class Publications extends IGB_Controller
  {
    use Resource_Controller;

    public function __construct()
    {
      parent::__construct();

      $this->resource = 'publication';
      $this->resources = 'publications';

      $this->data['title'] = lang('igb_'.$this->resources);
      $this->data['roles'] = $this->roles();
      $this->data['departments'] = $this->departments();

      $this->load->model($this->resources.'_model', 'model');
      $this->load->model('Types_model', 'types_model');
      $this->load->model('Super_types_model', 'super_types_model');
      $this->load->model('publications_people_model', 'authors_model');
      $this->load->model('users_model', 'users_model');
      $this->load->model('institutions_model', 'institutions_model');
    }

    public function index()
    {
      $this->load->library('pagination');
      $this->configure_validation();

      $page = $this->input->get('page') ?? 1;
      $per_page = $this->input->get('per-page') ?? 20;
      
      $this->data['criteria'] = [
        'sort_column' => $this->input->get('sort-column'),
        'sort_direction' => $this->input->get('sort-direction'),
        'terms' => $this->input->get('terms'),
        'uid' => $this->input->get('uid'),
        'creator' => $this->input->get('creator'),
        'pidentnr' => $this->input->get('pidentnr'),
        'pid' => $this->input->get('pid'),
        'fdate' => $this->input->get('fdate'),
        'people' => $this->input->get('people'),
        'person_id' => $this->input->get('person_id'),
        'supervisors' => $this->input->get('supervisors'),
        'institution_id' => $this->input->get('institution_id'),
        'tow' => $this->input->get('tow'),
        'ct' => $this->input->get('ct'),
        'dpmt' => $this->input->get('dpmt'),
        'pname_id' => $this->input->get('pname_id'),
        'periodical' => $this->input->get('periodical')
      ];
      $this->data[$this->resources] = $this->model->get_all($page, $per_page, $this->data['criteria']);
      $this->data['total'] = $this->model->count($this->data['criteria']);
      $this->data['people'] = $this->authors_model->for_publications($this->data[$this->resources], 'a');
      $this->data['supervisors'] = $this->authors_model->for_publications($this->data[$this->resources], 'b');
      $this->data['creators'] = $this->users_model->for_publications($this->data[$this->resources]);
      $this->data['types'] = $this->types_model->for_publications($this->data[$this->resources]);
      $this->data['all_types'] = $this->types_model->get_all_in_use();
      $this->data['institutions'] = $this->institutions_model->for_publications($this->data[$this->resources]);
      // error_log(print_r($this->data['types'], TRUE));

      $this->template($this->resources.'/index');
    }

    public function new()
    {
      $this->data[$this->resource] = $this->attribs();
      $this->handle_super_type();
      $this->set_authors_and_supervisors();

      if (!$this->can_create()) {
        $this->permission_denied();
      }

      // error_log(print_r($this->data[$this->resource], TRUE));

      $this->configure_validation();
      if ($this->form_validation->run() === FALSE) {
        $this->template($this->resources.'/form');
      } else {
        $id = $this->model->create($this->attribs());
        $this->authors_model->update($id, json_decode($this->data['people']), 'a');
        $this->authors_model->update($id, json_decode($this->data['supervisors']), 'b');
        $this->flash(lang('igb_notice_created'));

        $c = $this->input->post('continue'); 
        switch ($c) {
          case 'save & continue with same type':
            redirect('/'.$this->resources.'/new?super-type-id='.$this->data['super_type_id']);
            break;
          case 'save':
            redirect('/'.$this->resources);
            break;
        }
      }
    }

    public function edit($id) {
      $this->data['id'] = $id;
      $this->data[$this->resource] = $this->model->get($id);
      if (!$this->data[$this->resource]) {
        $this->not_found();
      }
      $this->handle_super_type();
      if (!$this->can_edit($this->current_user(), $this->data[$this->resource])) {
        $this->permission_denied();
      }
      $this->data['creator'] = $this->users_model->get($this->data[$this->resource]['uid']);
      $this->set_authors_and_supervisors($id);

      // error_log(print_r($this->data[$this->resource], TRUE));


      $this->configure_validation();
      if ($this->form_validation->run() === FALSE) {
        $this->data['return_to'] = $this->input->post('return_to');
        $this->template($this->resources.'/form');
      } else {
        $this->model->update($id, $this->attribs());
        $this->authors_model->update($id, json_decode($this->data['people']), 'a');
        $this->authors_model->update($id, json_decode($this->data['supervisors']), 'b');
        $this->flash(lang('igb_notice_updated'));

        $c = $this->input->post('continue'); 
        switch ($c) {
          case 'save & go back to the list':
            if ($url = $this->input->post('return_to')) {
              redirect($url);
            } else {
              redirect('/'.$this->resources);
            }
            break;
          case 'save':
            redirect('/'.$this->resources.'/edit/'.$id);
            break;
        }
      }
    }

    public function delete($id) {
      $this->data['id'] = $id;
      $this->data[$this->resource] = $this->model->get($id);
      $this->handle_super_type();
      if (!$this->can_delete($this->current_user(), $this->data[$this->resource])) {
        $this->permission_denied();
      }
      $this->authors_model->update($id, array());
      $this->model->delete($id);
      $this->flash(lang('igb_notice_deleted'));
      redirect($this->agent->referrer());
    }

    private function attribs() {
      $data = array(
        'dpmt' => $this->input->post('dpmt'),
        'ct' => $this->input->post('ct'),
        'fdate' => $this->input->post('fdate'),
        'end_fdate' => $this->input->post('end_fdate'),
        'title' => $this->input->post('title'),
        'notes' => $this->input->post('notes'),
        'place' => $this->input->post('place'),
        'edate' => $this->input->post('edate'),
        'end_date' => $this->input->post('end_date'),
        'impactf' => $this->input->post('impactf'),
        'epage' => $this->input->post('epage'),
        'pname_id' => $this->input->post('pname_id'),
        'periodical_name' => $this->input->post('periodical_name'),
        'doi' => $this->input->post('doi'),
        'booktitle' => $this->input->post('booktitle'),
        'volume' => $this->input->post('volume'),
        'issue' => $this->input->post('issue'),
        'organization' => $this->input->post('organization'),
        'institution_id' => $this->input->post('institution_id'),
        'institution_name' => $this->input->post('institution_name'),
        'chapvol' => $this->input->post('chapvol'),
        'mediatype' => $this->input->post('mediatype'),
        'semester' => $this->input->post('semester'),
        'editors' => $this->input->post('editors'),
        'faculty' => $this->input->post('faculty'),
        'open_access' => $this->input->post('open_access'),
        'authors' => $this->input->post('authors'),
        'klr_tow' => $this->input->post('klr_tow'),
        'eu_comm' => $this->input->post('eu_comm'),
        'num_comm_reports' => $this->input->post('num_comm_reports'),
        'num_position_papers' => $this->input->post('num_position_papers'),
        'num_reviews' => $this->input->post('num_reviews'),
        'num_reviews_eu' => $this->input->post('num_reviews_eu'),
        'green_open_access' => $this->input->post('green_open_access'),
        'link' => $this->input->post('link'),
        'embargo_date' => $this->input->post('embargo_date')
      );


      $data['ct'] = !!$this->input->post('ct');

      if (!isset($this->data['id'])) {
        $data['uid'] = $this->current_user()['uid'];

        if (!isset($data['fdate']) || !$data['fdate'])
          $data['fdate'] = strftime('%Y');
        
        if (!isset($data['end_fdate']) || !$data['end_fdate']) {
          if (isset($data['fdate']) && $data['fdate'])
            $data['end_fdate'] = $data['fdate'];
          else
            $data['end_fdate'] = strftime('%Y');
        }

        if (!isset($data['dpmt']) || !$data['dpmt'])
          $data['dpmt'] = $data['dpmt'] ?? $this->current_user()['dpmt'];
      }

      // error_log(print_r($this->current_user(), TRUE));
      // error_log(print_r($data, TRUE));

      return $data;
    }

    protected function configure_validation() {
      parent::configure_validation();

      if (isset($this->data['super_type'])) {
        $code = $this->data['super_type']['code'];

        $rules = [
          [
            'field' => 'dpmt',
            'label' => 'lang:igb_field_dpmt',
            'rules' => 'required|callback_validate_change_department|callback_is_department_list'
          ],[
            'field' => 'fdate',
            'label' => 'lang:igb_field_'.$code.'_fdate',
            'rules' => 'required|numeric'
          ],[
            'field' => 'klr_tow',
            'label' => 'lang:igb_field_klr_tow',
            'rules' => 'required|callback_keep_super_type'
          ],[
            'field' => 'people',
            'label' => 'lang:igb_field_people',
            'rules' => 'callback_people_required|callback_people_format'
          ]
        ];

        if ($code == 'pub') {
          array_push($rules, [
            'field' => 'title',
            'label' => 'lang:igb_field_'.$code.'_title',
            'rules' => 'required'
          ]);
          array_push($rules, [
            'field' => 'ct',
            'label' => 'lang:igb_field_ct',
            'rules' => 'callback_validate_verify'
          ]);
        } else {
          array_push($rules, [
            'field' => 'ct',
            'label' => 'lang:igb_field_ct',
            'rules' => 'callback_validate_verify'
          ]);
        }

        if ($code == 'pres') {
          array_push($rules, [
            'field' => 'title',
            'label' => 'lang:igb_field_'.$code.'_title',
            'rules' => 'required'
          ]);
          array_push($rules, [
            'field' => 'notes',
            'label' => 'lang:igb_field_'.$code.'_notes',
            'rules' => 'required'
          ]);
          array_push($rules, [
            'field' => 'place',
            'label' => 'lang:igb_field_'.$code.'_place',
            'rules' => 'required'
          ]);
          array_push($rules, [
            'field' => 'edate',
            'label' => 'lang:igb_field_'.$code.'_edate',
            'rules' => 'required'
          ]);
        }

        if ($code == 'lec') {
          array_push($rules, [
            'field' => 'title',
            'label' => 'lang:igb_field_'.$code.'_title',
            'rules' => 'required'
          ]);
          array_push($rules, [
            'field' => 'institution_id',
            'label' => 'lang:igb_field_'.$code.'_institution_id',
            'rules' => 'callback_required_autocomplete[institution_name]'
          ]);
          array_push($rules, [
            'field' => 'impactf',
            'label' => 'lang:igb_field_'.$code.'_impactf',
            'rules' => 'required'
          ]);
          array_push($rules, [
            'field' => 'semester',
            'label' => 'lang:igb_field_semester',
            'rules' => 'required'
          ]);
        }

        if ($code == 'sup') {
          array_push($rules, [
            'field' => 'title',
            'label' => 'lang:igb_field_'.$code.'_title',
            'rules' => 'required'
          ]);
          array_push($rules, [
            'field' => 'institution_id',
            'label' => 'lang:igb_field_'.$code.'_institution_id',
            'rules' => 'callback_required_autocomplete[institution_name]'
          ]);
          array_push($rules, [
            'field' => 'edate',
            'label' => 'lang:igb_field_'.$code.'_edate',
            'rules' => 'required'
          ]);
          array_push($rules, [
            'field' => 'people',
            'label' => 'lang:igb_field_'.$code.'_edate',
            'rules' => 'callback_supervision_unique'
          ]);
        }

        if ($code == 'media') {
          array_push($rules, [
            'field' => 'title',
            'label' => 'lang:igb_field_'.$code.'_title',
            'rules' => 'required'
          ]);
        }

        if ($code == 'comm') {
          array_push($rules, [
            'field' => 'title',
            'label' => 'lang:igb_field_'.$code.'_title',
            'rules' => 'required'
          ]);
          array_push($rules, [
            'field' => 'notes',
            'label' => 'lang:igb_field_'.$code.'_notes',
            'rules' => 'required'
          ]);
        }

        if ($code == 'edit') {
          array_push($rules, [
            'field' => 'title',
            'label' => 'lang:igb_field_'.$code.'_title',
            'rules' => 'required'
          ]);
          array_push($rules, [
            'field' => 'notes',
            'label' => 'lang:igb_field_'.$code.'_notes',
            'rules' => 'required'
          ]);
        }

        if ($code == 'conf') {
          array_push($rules, [
            'field' => 'title',
            'label' => 'lang:igb_field_'.$code.'_title',
            'rules' => 'required'
          ]);
          array_push($rules, [
            'field' => 'place',
            'label' => 'lang:igb_field_'.$code.'_place',
            'rules' => 'required'
          ]);
          array_push($rules, [
            'field' => 'edate',
            'label' => 'lang:igb_field_'.$code.'_edate',
            'rules' => 'required'
          ]);
        }

        $this->form_validation->set_rules($rules);
      }
    }

    private function set_authors_and_supervisors($id = FALSE)
    {
      $this->data['people'] = json_encode([]);
      $this->data['supervisors'] = json_encode([]);

      if ($id) {
        $mapper = function($e) {return [$e['laid'], $e['lpid'], $e['igb']];};

        // people
        $results = array_map($mapper, $this->authors_model->by_publication_id($id, 'a'));
        $this->data['people'] = json_encode($results);

        // supervisors
        $results = array_map($mapper, $this->authors_model->by_publication_id($id, 'b'));
        $this->data['supervisors'] = json_encode($results);
      }

      if ($params = $this->input->post('people')) {
        $this->data['people'] = $params;
      }

      if ($params = $this->input->post('supervisors')) {
        $this->data['supervisors'] = $params;
      }
    }

    private function handle_super_type()
    {
      if ($id = $this->data[$this->resource]['klr_tow']) {
        $this->data['type'] = $this->types_model->get_ignore_scope($id);
        $this->data['super_type_id'] = $this->data['type']['super_type_id'];
      } else {
        $this->data['super_type_id'] = $this->input->get('super-type-id');
      }

      if ($id = $this->data['super_type_id']) {
        $this->data['super_type'] = $this->super_types_model->get($id);
        $this->data['types'] = $this->types_model->by_super_type_id($id);
      } else {
        $this->data['super_types'] = $this->super_types_model->get_all();
      }
    }

    public function can_create()
    {
      if (!$this->has_role(['admin', 'library'])) {
        if ($this->data['super_type_id']) {
          return $this->data['super_type']['code'] != 'pub';
        }
      }

      return TRUE;
    }

    public function can_verify($user, $publication)
    {
      return $this->has_role(['admin', 'library', 'proofreader']);
    }

    public function validate_verify($value)
    {
      $previous_value = NULL;
      if (isset($this->data['id']) && $this->data['id']) {
        $previous_value = $this->data[$this->resource]['ct'];

        if (!!$previous_value != !!$value) {
          return $this->has_role(['admin', 'library', 'proofreader']);
        }
      }

      return TRUE;
    }

    public function validate_change_department($value)
    {
      $previous_value = $this->data[$this->resource]['dpmt'];

      if ($previous_value != $value) {
        if ($this->has_role(['user'])) {
          return !$this->data[$this->resource]['ct'];
        }
      }
      return TRUE;
    }

    public function can_edit($user, $publication)
    {
      $dpmts = preg_split('/,/', $publication['dpmt']);
      $type = $this->types_model->get_ignore_scope($publication['klr_tow']);
      $super_type = $this->super_types_model->get($type['super_type_id']);

      if ($this->has_role(['admin', 'library'])) {
        return TRUE;
      } else {
        if ($super_type['code'] == 'pub') {
          return FALSE;
        }
      }

      if ($this->has_role(['proofreader'])) {
        return (
          in_array($user['dpmt'], $dpmts) || 
          $user['uid'] == $publication['uid']
        );
      }

      return (
        $user['uid'] == $publication['uid'] &&
        $publication['ct'] == '0'
      );
    }

    public function can_delete($user, $publication)
    {
      return $this->can_edit($user, $publication);
    }

    public function people_required($people)
    {
      if (empty(json_decode($people))) {
        return FALSE;
      }

      return TRUE;
    }

    public function people_format($people) {
      foreach (json_decode($people) as $person) {
        if (!is_numeric($person[1])) {
          // error_log(print_r($people, TRUE));
          return preg_match('/^[\p{Lu}\p{Lt}][^,]*, [\p{Lu}\p{Lt}].*$/', $person[1]) == 1;
        }
      }

      return TRUE;
    }

    public function keep_super_type($tow) {
      if (isset($this->data['id']) && $this->data['id']) {
        $id = $this->data['id'];
        $old = $this->data[$this->resource]['klr_tow'];
        $old = $this->types_model->get($old);
        $new = $this->types_model->get($tow);
        return $old['super_type_id'] == $new['super_type_id'];
      }

      return TRUE;
    }

    public function supervision_unique($people) {
      $people = json_decode($people);
      error_log(print_r($this->data[$this->resource], TRUE));
      
      if (isset($this->data[$this->resource]['klr_tow']) && sizeof($people) > 0) {
        $candidates = $this->model->get_all(1, 1, [
          'edate' => $this->data[$this->resource]['edate'],
          'tow' => $this->data[$this->resource]['klr_tow'],
          'person_id' => $people[0][1]
        ]);

        if (sizeof($candidates) == 0) return TRUE;
        if (sizeof($candidates) == 1) {
          if (isset($this->data['id']) && $this->data['id']) {
            return $candidates[0]['pid'] == $this->data['id'];
          }
        }

        return FALSE;
      }

      return TRUE;
    }
  }
?>