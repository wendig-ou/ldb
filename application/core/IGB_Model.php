<?php 
  abstract class IGB_Model extends CI_Model {
    public function __construct()
    {
      parent::__construct();

      $this->table_name = 'SET ME IN SUBCLASS!';
      $this->id_column = 'id';
      $this->sort_column = 'name';
      $this->sort_direction = 'asc';
      $this->name_column = 'name';
      $this->search_column = 'name';
    }

    public function db()
    {
      return $this->db;
    }

    public function get($id)
    {
      $query = $this->db()->where($this->id_column, $id)->get($this->table_name);
      return $this->modify($query->row_array());
    }

    public function by_name($name)
    {
      $query = $this->db()->where($this->name_column, $name)->get($this->table_name);
      return $query->row_array();
    }

    public function filter_query($options = [])
    {
      $options = $this->apply_defaults($options);

      $query = $this->base_query();
      $query = $this->apply_sorting($query, $options);
      $query = $this->apply_term_search($query, $options);
      $query = $this->apply_pagination($query, $options);

      return $query;
    }

    public function apply_defaults($options = [])
    {
      $defaults = [
        'sort_column' => $this->sort_column,
        'sort_direction' => $this->sort_direction,
        'terms' => ''
      ];
      return array_merge($defaults, array_filter($options, function($value) {
        return !empty($value) || $value == '0';
      }));
    }

    public function apply_sorting($query, $options = [])
    {
      return $query->order_by(
        $this->table_name.'.'.$options['sort_column'],
        $options['sort_direction']
      );
    }

    public function apply_term_search($query, $options = [])
    {
      if ($v = $options['terms']) {
        $query = $query->like($this->search_column, $v);
      }

      return $query;
    }

    public function apply_pagination($query, $options = [])
    {
      if (isset($options['page'])) {
        $query = $query
          ->limit($options['per_page'])
          ->offset(($options['page'] - 1) * $options['per_page']);
      }

      return $query;
    }

    public function base_query()
    {
      return $this->db->from($this->table_name);
    }

    public function get_all($page = 1, $per_page = 20, $options = [])
    {
      $options['page'] = $page;
      $options['per_page'] = $per_page;
      $results = $this->filter_query($options)->get()->result_array();
      return array_map([$this, 'modify'], $results);
    }

    public function count($options)
    {
      return $this->filter_query($options)->count_all_results();
    }

    public function autocomplete($terms)
    {
      $query = $this->db()
        ->select($this->name_column . ' AS label, '. $this->id_column . ' AS value')
        ->order_by($this->sort_column)
        ->like($this->search_column, $terms, 'both', TRUE)
        ->get($this->table_name, 10);
      return $query->result_array();
    }

    public function modify($result) {
      return $result;
    }

    public function prepare($attribs) {
      return $attribs;
    }

    public function create($attribs)
    {
      $this->db()->trans_start();
      $attribs = $this->prepare($attribs);
      $this->db()->insert($this->table_name, $attribs);
      $id = $this->db()->insert_id();
      $this->db()->trans_complete();
      return $id;
    }

    public function update($id, $attribs)
    {
      $this->db()->trans_start();
      $attribs = $this->prepare($attribs);
      $this->db()
        ->set($attribs)
        ->where($this->id_column, $id)
        ->update($this->table_name);
      $this->db()->trans_complete();
    }

    public function delete($id)
    {
      $this->db()->where($this->id_column, $id)->delete($this->table_name);
    }

    public function date_to_human($date)
    {
      return preg_replace('/^([0-9]{4})([0-9]{2})([0-9]{2})$/', '$3.$2.$1', $date);
    }

    public function human_to_date($date)
    {
      return preg_replace('/^([0-9]{2}).([0-9]{2}).([0-9]{4})$/', '$3$2$1', $date);
    }
  }
?>