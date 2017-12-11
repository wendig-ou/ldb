<?php 
  class Publications_model extends IGB_Model
  {
    public function __construct()
    {
      parent::__construct();

      $this->table_name = 'publications';
      $this->id_column = 'pid';
      $this->name_column = 'title';
      $this->search_column = 'title';
      $this->sort_column = 'pid';
      $this->sort_direction = 'desc';
    }

    public function by_ris_id($id) {
      $query = $this->db()->where('ris_id', $id)->get($this->table_name);
      return $query->row_array();
    }

    public function filter_query($options = [])
    {
      $options = $this->apply_defaults($options);
      $query = $this->base_query();

      if ($options['sort_column'] == 'people') {
        $query = $query
          ->join('igb_ldb_lom_authors AS a', 'a.publication_id = publications.pid', 'left')
          ->join('igb_ldb_lom_persons AS p', 'a.lpid = p.lpid', 'left')
          ->order_by('p.Person '.$options['sort_direction'])
          ->where('a.ord', 0)
          ->group_by('publications.pid');
      } else {
        $query = $this->apply_sorting($query, $options);
      }
      
      $query = $this->apply_term_search($query, $options);
      $query = $this->apply_pagination($query, $options);


      $query = $query->select('publications.*');

      if (isset($options['uid']) && $options['uid']) {
        $query = $query->where('uid', $options['uid']);
      }

      if (isset($options['pid']) && $options['pid']) {
        $query = $query->where('publications.pid', $options['pid']);
      }

      if (isset($options['pidentnr']) && $options['pidentnr']) {
        $query = $query->where('pidentnr', $options['pidentnr']);
      }

      if (isset($options['fdate']) && $options['fdate']) {
        $years = preg_split('/\s*,\s*/', $options['fdate']);
        $where = [];
        foreach ($years as $year) {
          $year = $this->db->escape($year);
          $where[] = "(fdate <= ".$year." AND (end_fdate IS NULL OR end_fdate = '' OR end_fdate >= ".$year."))";
        }
        $where = implode(' OR ', $where);
        // error_log($where." AND NOT (fdate IS NULL OR fdate = '') AND (end_fdate IS NULL OR end_fdate = '')");
        $query = $query->where(
          '('.$where." AND NOT ((fdate IS NULL OR fdate = '') AND (end_fdate IS NULL OR end_fdate = '')))"
        );
      }

      if (isset($options['people']) && $options['people']) {
        $people = $this->db->escape_like_str($options['people']);
        $query = $query
          ->join('igb_ldb_lom_authors l', 'l.publication_id = publications.pid', 'left')
          ->join('igb_ldb_lom_persons pe', 'l.lpid = pe.lpid', 'left')
          ->like('pe.Person', $options['people'])
          ->where("(pe.Person LIKE '%".$people."%' OR publications.authors LIKE '%".$people."%')");
      }

      if (isset($options['person_id']) && $options['person_id']) {
        $query = $query
          ->join('igb_ldb_lom_authors l', 'l.publication_id = publications.pid', 'left')
          ->where('l.lpid', $options['person_id']);
      }

      if (isset($options['institution_id']) && $options['institution_id']) {
        $query = $query->where('institution_id', $options['institution_id']);
      }

      if (isset($options['tow']) && $options['tow']) {
        $tows = preg_split('/\s*,\s*/', $options['tow']);
        $query = $query->where_in('klr_tow', $tows);
      }

      if (isset($options['ct']) && ($options['ct'] || $options['ct'] == '0')) {
        $query = $query->where('ct', $options['ct']);
      }

      if (isset($options['dpmt']) && $options['dpmt']) {
        $query = $query->like('publications.dpmt', $options['dpmt']);
      }

      if (isset($options['pname_id']) && $options['pname_id']) {
        $query = $query->where('pname_id', $options['pname_id']);
      }

      if (isset($options['periodical']) && $options['periodical']) {
        $query = $query
          ->join('periodicals per', 'per.pid = publications.pname_id', 'left')
          ->like('per.pname', $options['periodical']);
      }

      if (isset($options['creator']) && $options['creator']) {
        $query = $query
          ->join('passwd pw', 'pw.uid = publications.uid', 'left')
          ->like('comment', $options['creator']);
      }

      // error_log(print_r($options, TRUE));
      error_log($query->get_compiled_select(NULL, FALSE));

      return $query;
    }

    public function prepare($attribs) {
      if (empty($attribs['institution_id'])) {
        if (!empty($attribs['institution_name'])) {
          $this->load->model('Institutions_model', 'institutions_model');
          $id = $this->institutions_model->create(['institut' => $attribs['institution_name']]);
          $attribs['institution_id'] = $id;
        }
      }
      unset($attribs['institution_name']);

      if (empty($attribs['pname_id'])) {
        if (!empty($attribs['periodical_name'])) {
          $this->load->model('Periodicals_model', 'periodicals_model');
          $id = $this->periodicals_model->create(['pname' => $attribs['periodical_name']]);
          $attribs['pname_id'] = $id;
        }
      }
      unset($attribs['periodical_name']);

      if (isset($attribs['end_fdate'])) {
        if ($attribs['end_fdate'] == '-') {
          $attribs['end_fdate'] = NULL;
        }
      } else {
        if (isset($attribs['fdate'])) {
          $attribs['end_fdate'] = $attribs['fdate'];
        }
      }

      if (isset($attribs['edate'])) {
        $attribs['edate'] = $this->human_to_date($attribs['edate']);
      }
      if (isset($attribs['end_date'])) {
        $attribs['end_date'] = $this->human_to_date($attribs['end_date']);
      }

      return $attribs;
    }

    public function modify($record) {
      if ($record['pid']) {
        if ($record['end_fdate'] == '') {
          $record['end_fdate'] = '-';
        }
      }

      if (isset($record['edate'])) {
        $record['edate'] = $this->date_to_human($record['edate']);
      }

      if (isset($record['end_date'])) {
        $record['end_date'] = $this->date_to_human($record['end_date']);
      }

      return $record;
    }
  }
?>