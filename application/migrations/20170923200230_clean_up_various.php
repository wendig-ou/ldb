<?php 
  class Migration_Clean_up_various extends CI_Migration {
    public function up() {
      echo get_class($this) . "\n";

      # see https://issues.wendig.io/issues/14
      $this->db
        ->where('lpid', 2699)
        ->where('laid', 2127)
        ->delete('igb_ldb_lom_authors');

      # see https://issues.wendig.io/issues/5
      $this->db->where('iid', 28)->delete('igb_ldb_institutions');
      $this->db->set('institution_id', NULL)->where('institution_id', 28)->update('publications');
    }

    public function down() {
      die("this migration can't be reversed");
    }
  }
?>