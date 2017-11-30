<?php 
  class Migration_Add_indices extends CI_Migration {
    public function up() {
      echo get_class($this) . "\n";

      $query = "ALTER TABLE igb_ldb_lom_authors ADD INDEX speedy (lpid)";
      $this->db->query($query);

      $query = "ALTER TABLE igb_ldb_lom_authors ADD INDEX matchy (publication_id)";
      $this->db->query($query);

      $query = "ALTER TABLE publications ADD INDEX speedy (pname_id)";
      $this->db->query($query);
    }

    public function down() {
      die("this migration can't be reversed");
    }
  }
?>