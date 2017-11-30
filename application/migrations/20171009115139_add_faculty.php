<?php 
  class Migration_Add_faculty extends CI_Migration {
    public function up() {
      echo get_class($this) . "\n";

      $this->dbforge->add_column('publications', [
        'faculty' => [
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