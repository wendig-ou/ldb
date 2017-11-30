<?php 
  class Migration_Add_ris_fields extends CI_Migration {
    public function up() {
      echo get_class($this) . "\n";

      $this->dbforge->add_column('publications', [
        'open_access' => [
          'type' => 'int',
          'constraint' => 1,
          'default' => 0
        ],
        'ris_id' => [
          'type' => 'varchar',
          'constraint' => 20
        ]
      ]);
    }

    public function down() {
      die("this migration can't be reversed");
    }
  }
?>