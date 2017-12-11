<?php 
  class Migration_Correct_tow0115 extends CI_Migration {
    public function up() {
      echo get_class($this) . "\n";

      $this->db
        ->set('klr_tow', '01.15')
        ->where('klr_tow', '0. 15')
        ->update('publications');
    }

    public function down() {
      die("this migration can't be reversed");
    }
  }
?>