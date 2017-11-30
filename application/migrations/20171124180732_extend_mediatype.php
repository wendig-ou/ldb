<?php 
  class Migration_Extend_mediatype extends CI_Migration {
    public function up() {
      echo get_class($this) . "\n";

      $this->dbforge->modify_column('publications', [
        'mediatype' => [
          'type' => 'varchar',
          'constraint' => 255,
          'default' => ''
        ]
      ]);
    }

    public function down() {
      die("this migration can't be reversed");
    }
  }
?>