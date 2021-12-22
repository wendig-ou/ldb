<?php 
  class Migration_Deactivate_ToW extends CI_Migration {
    public function up() {
      echo get_class($this) . "\n";

      $this->db->
        where('tow', '07.02')->
        set('active', 0)->
        update('ToW');
    }

    public function down() {
      die("this migration can't be reversed");
    }
  }
?>
