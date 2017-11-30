<?php 
  class Admin_Controller extends IGB_Controller {

    public function __construct() {
      parent::__construct();

      if (!$this->has_role(['admin', 'library'])) {
        $this->permission_denied();
      }
    }

  }
?>