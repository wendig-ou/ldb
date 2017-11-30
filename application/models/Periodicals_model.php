<?php 
  class Periodicals_model extends IGB_Model {
    public function __construct() {
      parent::__construct();

      $this->table_name = 'periodicals';
      $this->id_column = 'pid';
      $this->sort_column = 'pid';
      $this->sort_direction = 'desc';
      $this->name_column = 'pname';
      $this->search_column = 'pname';
    }

    public function usage_count($id)
    {
      $query = $this->db->where('pname_id', $id);
      return $query->count_all_results('publications');
    }

    public function filter_query($options = [])
    {
      $query = parent::filter_query($options);

      $query = $query
        ->select('periodicals.*, count(p.pid) AS pub_count')
        ->join('publications AS p', 'p.pname_id = periodicals.pid', 'left')
        ->group_by('periodicals.pid');

      // error_log('-----');
      // error_log($query->get_compiled_select(NULL, FALSE));

      return $query;
    }
  }
?>