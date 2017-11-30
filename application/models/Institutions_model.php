<?php 
  class Institutions_model extends IGB_Model {
    public function __construct() {
      parent::__construct();

      $this->table_name = 'igb_ldb_institutions';
      $this->id_column = 'iid';
      $this->sort_column = 'iid';
      $this->sort_direction = 'desc';
      $this->name_column = 'institut';
      $this->search_column = 'institut';
    }

    public function usage_count($id)
    {
      $query = $this->db->where('institution_id', $id);
      return $query->count_all_results('publications');
    }

    public function for_publications($publications)
    {
      $results = [];
      foreach ($publications as $p) {
        if (! $p['institution_id'] == 0) {
          $results[$p['institution_id']] = NULL;
        }
      }
      if (empty($results)) {return $results;}

      $query = $this->db
        ->where_in('iid', array_keys($results))
        ->get($this->table_name);
      $records = $query->result_array();

      foreach ($records as $record) {
        $results[$record['iid']] = $record;
      }
      return $results;
    }

    public function filter_query($options = [])
    {
      $query = parent::filter_query($options);

      $query = $query
        ->select('igb_ldb_institutions.*, count(p.pid) AS pub_count')
        ->join('publications AS p', 'p.institution_id = igb_ldb_institutions.iid', 'left')
        ->group_by('igb_ldb_institutions.iid');

      return $query;
    }
  }
?>