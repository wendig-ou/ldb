<?php 
  class Types_model extends IGB_Model
  {
    public function __construct()
    {
      parent::__construct();

      $this->table_name = 'ToW';
      $this->id_column = 'tow';
      $this->sort_column = 'tow';
    }

    public function db() {
      return $this->db->where('active = 1');
    }

    public function get_active()
    {
      $query = $this->db
        ->where('active = 1')
        ->get($this->table_name);

      $results = $query->result_array();
      return array_map([$this, 'modify'], $results);
    }

    public function get_all_in_use() {
      $query = $this->db()
        ->reset_query()
        ->select('ToW.*')
        ->join('publications p', 'p.klr_tow = ToW.tow', 'left')
        ->group_by('ToW.tow')
        ->where('p.pid IS NOT NULL')
        ->order_by('tow')
        ->get($this->table_name);
      return $query->result_array();
    }

    public function get_ignore_scope($id) {
      $query = $this->db()->reset_query()->where($this->id_column, $id)->get($this->table_name);
      return $query->row_array();
    }

    public function by_super_type_id($id)
    {
      $query = $this->db()->
        where('super_type_id', $id)
        ->order_by($this->sort_column)
        ->get($this->table_name);
      return $query->result_array();
    }

    public function for_publications($publications)
    {
      $results = [];
      foreach ($publications as $p) {
        if (! $p['klr_tow'] == 0) {
          $results[$p['klr_tow']] = NULL;
        }
      }
      if (empty($results)) {return $results;}

      $query = $this->db
        ->select('t.*, s.name super_type_name, s.code super_type_code')
        ->where_in('tow', array_keys($results))
        ->join('super_types s', 's.id = t.super_type_id', 'LEFT')
        ->get($this->table_name.' t');
      $records = $query->result_array();

      foreach ($records as $record) {
        $results[$record['tow']] = $record;
      }
      return $results;
    }
  }
?>