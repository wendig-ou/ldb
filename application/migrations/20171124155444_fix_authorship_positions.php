<?php 
  class Migration_Fix_authorship_positions extends CI_Migration {
    public function up() {
      echo get_class($this) . "\n";

      $query = $this->db->select('pid')->get('publications');
      foreach ($query->result_array() as $pub) {
        $query = $this->db
          ->where('publication_id', $pub['pid'])
          ->order_by('ord', 'ASC')
          ->get('igb_ldb_lom_authors');
        foreach ($query->result_array() as $i => $record) {
          $this->db
            ->where('laid', $record['laid'])
            ->set('ord', $i)
            ->update('igb_ldb_lom_authors');
        }
      }
    }

    public function down() {
      die("this migration can't be reversed");
    }
  }
?>