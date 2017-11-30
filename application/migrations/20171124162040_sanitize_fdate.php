<?php 
  class Migration_Sanitize_fdate extends CI_Migration {
    public function up() {
      echo get_class($this) . "\n";

      $this->dbforge->add_column('publications', [
        'legacy_fdate' => [
          'type' => 'varchar',
          'constraint' => 20,
          'default' => ''
        ]
      ]);

      $query = $this->db->select('pid, fdate')->get('publications');
      foreach ($query->result_array() as $pub) {
        $this->db
          ->where('pid', $pub['pid'])
          ->set('fdate', preg_replace('/^([0-9]{4}).*$/', '$1', $pub['fdate']))
          ->set('legacy_fdate', $pub['fdate'])
          ->update('publications');
      }
    }

    public function down() {
      die("this migration can't be reversed");
    }
  }
?>