<?php 
  class Migration_Sanitize_organization_field extends CI_Migration {
    public function up() {
      echo get_class($this) . "\n";

      $this->dbforge->add_column('publications', [
        'institution_id' => ['type' => 'INT', 'constraint' => 11]
      ]);

      foreach ($this->db->get('publications')->result_array() as $record) {
        $value = $record['organization'];
        if ($value) {
          $by_id = $this->db->where('iid', $value)->get('igb_ldb_institutions')->row_array();
          if ($by_id) {
            // write id to institution_id and empty organization
            $this->db
              ->set('organization', NULL)
              ->set('institution_id', $value)
              ->where('pid', $record['pid'])
              ->update('publications');
          } else {
            if (is_numeric($value)) {
              die("'".$value."' should not be numeric!\n");
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