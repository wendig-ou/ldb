<?php 
  class Migration_Shorten_legacy_authors extends CI_Migration {
    public function up() {
      echo get_class($this) . "\n";

      $this->db
        ->set('authors', NULL)
        ->where('length(authors) > 254')
        ->update('publications');

      $this->dbforge->modify_column('publications', [
        'authors' => [
          'type' => 'varchar',
          'constraint' => 255,
          'default' => NULL
        ]
      ]);

      $query = "ALTER TABLE publications ADD INDEX legacy_authors (authors)";
      $this->db->query($query);
    }

    public function down() {
      die("this migration can't be reversed");
    }
  }
?>