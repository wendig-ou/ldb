<?php 
  class Migration_Add_tow_software extends CI_Migration {
    public function up() {
      echo get_class($this) . "\n";

      $id = $this->db->where('code', 'pub')->get('super_types')->result_array()[0]['id'];
      $this->db->insert('ToW', [
        'super_type_id' => $id,
        'tow' => '01.16',
        't_desc' => 'software',
        'active' => 1
      ]);

      $this->db->
        set('help', NULL)->
        where('code', 'sup')->
        update('super_types');
    }

    public function down() {
      die("this migration can't be reversed");
    }
  }
?>