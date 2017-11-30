<?php 
  class Migration_Add_semester extends CI_Migration {
    public function up() {
      echo get_class($this) . "\n";

      $this->dbforge->add_column('publications', array(
        'semester' => array(
          'type' => 'VARCHAR',
          'constraint' => 10
        )
      ));
    }

    public function down() {
      die("this migration can't be reversed");
    }
  }
?>