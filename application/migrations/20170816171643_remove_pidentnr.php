<?php 
  class Migration_Remove_pidentnr extends CI_Migration {
    public function up() {
      echo get_class($this) . "\n";
      
      $this->dbforge->add_column('igb_ldb_lom_authors', array(
        'publication_id' => array(
          'type' => 'int',
          'constraint' => 10,
          'not_null' => TRUE
        )
      ));

      $query = $this->db->get('publications');
      foreach ($query->result_array() as $publication) {
        $query = $this->db
          ->set('publication_id', intval($publication['pid']))
          ->where('pidentnr', intval($publication['pidentnr']))
          ->update('igb_ldb_lom_authors');
      }
    }

    public function down() {
      die("this migration can't be reversed");
    }
  }
?>