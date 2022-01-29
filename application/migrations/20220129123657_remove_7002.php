<?php 
  class Migration_Remove_7002 extends CI_Migration {
    public function up() {
      echo get_class($this) . "\n";

      $this->db->
        where('tow', '07.02')->
        delete('ToW');

      $this->dbforge->add_column('publications', [
        'event_purpose' => [
          'type' => 'varchar',
          'constraint' => 255,
          'default' => NULL
        ]
      ]);
    }

    public function down() {
      die("this migration can't be reversed");
    }
  }
?>
