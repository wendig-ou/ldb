<?php 
  class Migration_Add_roles_to_users extends CI_Migration {
    public function up() {
      echo get_class($this) . "\n";

      $this->dbforge->add_column('passwd', array(
        'role' => array(
          'type' => 'VARCHAR',
          'constraint' => 20,
          'default' => 'user'
        ),
        'salt' => array(
          'type' => 'VARCHAR',
          'constraint' => 6
        )
      ));

      $this->dbforge->modify_column('passwd', array(
        'pw' => array('type' => 'VARCHAR', 'constraint' => 64)
      ));

      $this->db
        ->set('role', 'admin')
        ->set('dpmt', 'B')
        ->where('uname', 'supervisor')
        ->update('passwd');

      $this->db->set('pw', NULL);
      $this->db->where('uname !=', 'supervisor');
      $this->db->update('passwd');

      # pushed up from a later migration: 20171110134450_add_active_to_users
      $this->dbforge->add_column('passwd', [
        'active' => [
          'type' => 'int',
          'constraint' => 1,
          'default' => 0
        ]
      ]);
    }

    public function down() {
      die("this migration can't be reversed");
    }
  }
?>