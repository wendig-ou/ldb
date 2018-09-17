<?php 
  class Migration_Add_green_open_access_fields extends CI_Migration {
    public function up() {
      echo get_class($this) . "\n";

      $this->dbforge->add_column('publications', [
        'green_open_access' => [
          'type' => 'int',
          'constraint' => 1,
          'default' => 0
        ],
        'link' => [
          'type' => 'varchar',
          'constraint' => 255
        ],
        'embargo_date' => array(
          'type' => 'VARCHAR',
          'constraint' => 30
        )
      ]);
    }

    public function down() {
      die("this migration can't be reversed");
    }
  }
?>