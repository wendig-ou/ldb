<?php 
  class Migration_Remove_html_entities extends CI_Migration {
    public function up() {
      echo get_class($this) . "\n";
      
      $tables = [
        'ToW', 'authors', 'defaults', 'igb_ldb_institutions', 
        'igb_ldb_lom_authors', 'igb_ldb_lom_persons', 'igb_ldb_system_parms',
        'migrations', 'p_types', 'passwd', 'periodicals', 'publications'
      ];

      foreach ($tables as $table) {
        $records = $this->db->get($table)->result_array();
        foreach ($records as $record) {
          foreach ($record as $field => $value) {
            if (preg_match('/&[a-zA-Z0-9#]+;/', $value)) {
              $fixed = html_entity_decode($value);
              $this->db->set($field, $fixed)->where($field, $value)->update($table);
            }
          }
        }
      }
    }

    public function down() {
      die("this migration can't be reversed");
    }
  }
?>