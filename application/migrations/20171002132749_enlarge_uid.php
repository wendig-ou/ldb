<?php 
  class Migration_Enlarge_uid extends CI_Migration {
    public function up() {
      echo get_class($this) . "\n";

      $this->dbforge->modify_column('publications', [
        'uid' => [
          'type' => 'int',
          'constraint' => 11,
          'unsigned' => TRUE,
          'default' => NULL
        ]
      ]);

      $this->dbforge->modify_column('passwd', [
        'uid' => [
          'type' => 'int',
          'constraint' => 11,
          'unsigned' => TRUE,
          'auto_increment' => TRUE,
          'null' => FALSE
        ]
      ]);
    }

    public function down() {
      die("this migration can't be reversed");
    }
  }
?>