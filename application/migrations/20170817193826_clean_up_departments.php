<?php 
  class Migration_Clean_up_departments extends CI_Migration {
    public function up() {
      echo get_class($this) . "\n";
      
      $mapping = array(
        'A1' => '1',
        'A2' => '2',
        'A3' => '3',
        'A4' => '4',
        'A4A5' => '4',
        'A5' => '5',
        'AD' => 'D',
        'AL' => 'D',
        'CL' => '6'
      );

      foreach ($mapping as $from => $to) {
        $this->db->set('dpmt', $to)->where('dpmt', $from)->update('publications');
        $this->db->set('dpmt', $to)->where('dpmt', $from)->update('passwd');
      }
    }

    public function down() {
      die("this migration can't be reversed");
    }
  }
?>