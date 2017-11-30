<?php 
  class Migration_Add_end_fdate extends CI_Migration {
    public function up() {
      echo get_class($this) . "\n";

      $this->dbforge->add_column('publications', array(
        'end_fdate' => array(
          'type' => 'VARCHAR',
          'constraint' => 30
        )
      ));

      $query = $this->db->get('publications');
      foreach ($query->result_array() as $record) {
        if ($value = $record['fdate']) {
          $new_value = preg_replace('/0000$/', '', $value);
          $new_end_value = substr($value, 0, 4);
          $this->db
            ->set('fdate', $new_value)
            ->set('end_fdate', $new_end_value)
            ->where('pid', $record['pid'])
            ->update('publications');
        }
      }
    }

    public function down() {
      die("this migration can't be reversed");
    }
  }
?>