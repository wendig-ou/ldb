<?php 
  class People_model extends IGB_Model
  {
    public function __construct()
    {
      parent::__construct();

      $this->table_name = 'igb_ldb_lom_persons';
      $this->id_column = 'lpid';
      $this->sort_column = 'lpid';
      $this->sort_direction = 'desc';
      $this->name_column = 'Person';
      $this->search_column = 'Person';
    }

    public function by_id($ids)
    {
      $query = $this->db->where_in('lpid', $ids)->get($this->table_name);
      return $query->result_array();
    }

    public function by_name($name)
    {
      $query = $this->db->where('Person', $name)->get($this->table_name);
      return $query->row_array();
    }

    public function usage_count($id)
    {
      $query = $this->db
        ->join('igb_ldb_lom_authors l', 'l.publication_id = publications.pid', 'left')
        ->where('l.lpid', $id);
      return $query->count_all_results('publications');
    }

    public function filter_query($options = [])
    {
      $query = parent::filter_query($options);

      $query = $query
        ->select('igb_ldb_lom_persons.*, count(p.pid) AS pub_count')
        ->join('igb_ldb_lom_authors AS a', 'a.lpid = igb_ldb_lom_persons.lpid', 'left')
        ->join('publications AS p', 'p.pid = a.publication_id', 'left')
        ->group_by('igb_ldb_lom_persons.lpid');

      // error_log('-----');
      // error_log($query->get_compiled_select(NULL, FALSE));

      return $query;
    }
  }
?>