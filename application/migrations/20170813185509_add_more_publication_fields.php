<?php 
  class Migration_Add_more_publication_fields extends CI_Migration {
    public function up() {
      echo get_class($this) . "\n";
      
      $this->dbforge->add_column('publications', array(
        'end_date' => array(
          'type' => 'VARCHAR',
          'constraint' => 26
        )
      ));

      $this->db
        ->set('ct', '1')
        ->where('ct', '+')
        ->update('publications');

      $this->db
        ->set('ct', '0')
        ->where('ct !=', '1')
        ->update('publications');
    }

    public function down() {
      die("this migration can't be reversed");
    }
  }
?>