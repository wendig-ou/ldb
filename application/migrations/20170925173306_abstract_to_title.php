<?php 
  class Migration_Abstract_to_title extends CI_Migration {
    public function up() {
      echo get_class($this) . "\n";

      $query = $this->db->where_in('klr_tow', ['06.01', '06.02'])->get('publications');
      foreach ($query->result_array() as $record) {
        if ($value = $record['abstract']) {
          $this->db
            ->set('abstract', NULL)
            ->set('title', $value)
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