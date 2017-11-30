<?php 
  class Migration_Restructure_departments extends CI_Migration {
    public function up() {
      echo get_class($this) . "\n";

      $this->dbforge->modify_column('publications', [
        'dpmt' => [
          'type' => 'varchar',
          'constraint' => 30,
          'default' => NULL
        ]
      ]);

      $this->dbforge->modify_column('passwd', [
        'dpmt' => [
          'type' => 'char',
          'constraint' => 1,
          'default' => NULL
        ]
      ]);

      $this->db
        ->where('dpmt', '0')
        ->set('dpmt', 'B')
        ->update('passwd');

      $this->db
        ->where('dpmt', '0')
        ->set('dpmt', 'B')
        ->update('publications');

      # Import LDAP Users
      $this->load->library('IGB_LDAP');
      $this->igb_ldap->sync_users();
    }

    public function down() {
      die("this migration can't be reversed");
    }
  }
?>