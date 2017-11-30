<?php 
  class Migration_Add_active_to_users extends CI_Migration {
    public function up() {
      echo get_class($this) . "\n";

      # column creation additionally added to 20170811153704_add_roles_to_users
      # not to break earlier migrations which also run the LDAP import
      # pushed up from a later migration: 20171110134450_add_active_to_users
      if (!$this->db->field_exists('active', 'passwd')) {
        $this->dbforge->add_column('passwd', [
          'active' => [
            'type' => 'int',
            'constraint' => 1,
            'default' => 0
          ]
        ]);
      }

      # Import LDAP Users (again)
      $this->load->library('IGB_LDAP');
      $this->igb_ldap->sync_users();
    }

    public function down() {
      die("this migration can't be reversed");
    }
  }
?>