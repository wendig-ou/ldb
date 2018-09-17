<?php 
  class Migration_Rename_types_03 extends CI_Migration {
    public function up() {
      echo get_class($this) . "\n";

      $this->db->
        set('description', 'Supervision of bachelor, master and doctoral thesis and finalized habilitations. Only completed theses, no on-going supervision.')->
        set('help', 'Supervision of bachelor, master and doctoral thesis and finalized habilitations. Only completed theses, no on-going supervision. For date please use the date of the defense.')->
        where('code', 'sup')->
        update('super_types');

      $this->db->
        set('t_desc', 'supervision of finalized doctoral thesis')->
        where('tow', '04.02')->
        update('ToW');
    }

    public function down() {
      die("this migration can't be reversed");
    }
  }
?>