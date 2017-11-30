<?php 
  class Super_types_model extends IGB_Model
  {
    public function __construct()
    {
      parent::__construct();

      $this->table_name = 'super_types';
      $this->order_column = 'id';
    }
  }
?>