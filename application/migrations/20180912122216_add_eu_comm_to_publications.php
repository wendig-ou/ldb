<?php 
  class Migration_Add_eu_comm_to_publications extends CI_Migration {
    public function up() {
      echo get_class($this) . "\n";

      $this->dbforge->add_column('publications', [
        'eu_comm' => [
          'type' => 'int',
          'constraint' => 1,
          'default' => 0
        ]
      ]);
    }

    public function down() {
      die("this migration can't be reversed");
    }
  }
?>