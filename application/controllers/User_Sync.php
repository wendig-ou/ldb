<?php
  class User_Sync extends IGB_Controller
  {
    public function index()
    {
      $this->load->library('IGB_LDAP');
      $this->igb_ldap->sync_users();
    }
  }
?>
