<?php 
  class Users_model extends IGB_Model
  {
    public function __construct()
    {
      parent::__construct();

      $this->table_name = 'passwd';
      $this->id_column = 'uid';
      $this->sort_column = 'uid';
      $this->sort_direction = 'desc';
      $this->search_column = 'uname';
    }

    public function filter_query($options = [])
    {
      $query = parent::filter_query($options);

      if (!empty($options['terms'])) {
        $query = $query->or_like('comment', $options['terms']);
      }

      return $query;
    }

    public function for_publications($publications)
    {
      $results = [];
      foreach ($publications as $p) {
        $results[$p['uid']] = NULL;
      }
      if (empty($results)) {return $results;}

      $query = $this->db
        ->where_in('uid', array_keys($results))
        ->get($this->table_name);
      $records = $query->result_array();

      foreach ($records as $record) {
        $results[$record['uid']] = $record;
      }
      return $results;
    }

    public function get_by_username($username)
    {
      $query = $this->db()->where('uname', $username)->get($this->table_name);
      return $query->row_array();
    }

    public function get_active_by_name($name)
    {
      $query = $this->db()
        ->where('comment', $name)
        ->where('active', TRUE)
        ->get($this->table_name);
      return $query->row_array();
    }

    public function generate_salt()
    {
      return substr(md5(rand()), 0, 6);
    }

    public function hash($value, $salt)
    {
      return hash('sha256', $value.$salt);
    }
  }
?>