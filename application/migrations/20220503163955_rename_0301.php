<?php 
  class Migration_Rename_0301 extends CI_Migration {
    public function up() {
      echo get_class($this) . "\n";

      $this->db->
        set('t_desc', 'scientific event (keynote/plenary or invited talk)')->
        where('tow', '03.01')->
        update('ToW');
    }

    public function down() {
      die("this migration can't be reversed");
    }
  }
?>