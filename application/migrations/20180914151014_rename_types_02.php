<?php 
  class Migration_Rename_types_02 extends CI_Migration {
    public function up() {
      echo get_class($this) . "\n";

      $this->db->
        set('name', 'supervision and degrees')->
        where('name', 'supervision')->
        update('super_types');

      $this->db->
        set('t_desc', 'finalized habilitation treatise')->
        where('tow', '04.01')->
        update('ToW');

      $this->db->
        set('t_desc', 'supervision of finalized PhD thesis')->
        where('tow', '04.02')->
        update('ToW');

      $this->db->
        set('t_desc', 'supervision of finalized master or diploma thesis')->
        where('tow', '04.03')->
        update('ToW');

      $this->db->
        set('t_desc', 'supervision of finalized bachelor thesis')->
        where('tow', '04.04')->
        update('ToW');
    }

    public function down() {
      die("this migration can't be reversed");
    }
  }
?>