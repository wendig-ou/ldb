<?php 
  class IGB_LDAP {
    public function __construct()
    {
      $this->ldap = !!getenv('LDB_LDAP_HOST');
      $this->CI =& get_instance();
      $this->ldap_user_cache = NULL;
    }

    public function authenticate($username, $password)
    {
      $this->mail = $username;
      error_log('NEW LOGIN: '.$this->mail);

      // check if username is found as a mail address in LDAP
      if ($this->ldap_user()) {
        $username = $this->ldap_user()['uid'];
        error_log('username '.$this->mail.' translated to '.$username);
      }

      // load the user by username from the local database
      $this->CI->load->model('users_model');
      $user = $this->CI->users_model->get_by_username($username);

      if ($user) {
        error_log('user '.$username.' exists in DB');

        error_log('trying general password');
        if (getenv('LDB_GENERAL_AUTH') == $password) {
          error_log('success');
          return $username;
        }

        error_log('trying legacy plain text password');
        if ($user['pw'] == $password) {
          error_log('success');
          return $username;
        }

        error_log('trying hashed password');
        $hashed = $this->CI->users_model->hash($password, $user['salt']);
        if ($hashed == $user['pw']) {
          error_log('success');
          return $username;
        }

        error_log('trying ldap');
        if ($this->ldap) {
          if ($this->ldap_user()) {
            $dn = $this->ldap_user()['dn'];
          } else {
            $dn = sprintf(getenv('LDB_LDAP_BIND_TPL'), $username);
          }
          if ($this->ldap_authenticate($dn, $password)) {
            error_log('success');
            return $username;
          }
        }
      }

      return FALSE;
    }

    public function sync_users()
    {
      if ($this->ldap) {
        $this->CI->load->model('users_model');

        foreach ($this->ldap_users() as $username => $ldap_user) {
          if ($db_user = $this->CI->users_model->get_by_username($username)) {
            $this->CI->users_model->update($db_user['uid'], [
              // 'dpmt' => $ldap_user['department'],
              'comment' => $ldap_user['fullname'],
              'active' => $ldap_user['active']
            ]);
          } else {
            $this->CI->users_model->create([
              'uname' => $username,
              // 'dpmt' => $ldap_user['department'],
              'comment' => $ldap_user['fullname'],
              'active' => $ldap_user['active']
            ]);
          }
        }
      }
    }

    public function ldap_users()
    {
      $connection = $this->connection();
      $ous = preg_split('/ +/', getenv('LDB_LDAP_OUS'));
      ldap_set_option($connection, LDAP_OPT_PROTOCOL_VERSION, 3);
      ldap_set_option($connection, LDAP_OPT_REFERRALS, 0);
      ldap_bind($connection, getenv('LDB_LDAP_BIND_USER'), getenv('LDB_LDAP_BIND_PASS'));

      $users = [];
      foreach($ous as $ou) {
        $search = ldap_search(
          $connection,
          $ou.','.getenv('LDB_LDAP_BASE_DN'),
          '(cn=*)',
          $this->attribs()
        );
        $results = ldap_get_entries($connection, $search);

        foreach ($results as $result) {
          $o = $this->ldap_to_array($result);

          if ($o['uid'] && $o['mail'] && $o['dn']) {
            $users[$o['uid']] = $o;
          } else {
            // echo "INCOMPLETE: ".$o['dn'].' , mail: '.$o['mail'].' uid: '.$o['uid']."\n";
          }
        }
      }

      return $users;
    }

    public function ldap_to_array($ldap) {
      $defaults = [
        'uid'       => NULL,
        'dn'        => NULL,
        "mail"      => NULL,
        "firstname" => NULL,
        "lastname"  => NULL,
        "fullname"  => NULL,
        "title"     => NULL,
        "department"=> NULL,
        "superior"  => NULL,
        "function"  => NULL,
        "active"    => NULL
      ];

      return array_merge($defaults, [
        'uid'       => @$ldap['uid'][0],
        'dn'        => @$ldap['dn'],
        "mail"      => @$ldap['mailprimaryaddress'][0],
        "firstname" => @$ldap['givenname'][0],
        "lastname"  => @$ldap['sn'][0],
        "fullname"  => @$ldap['cn'][0],
        "title"     => @$ldap['title'][0],
        "department"=> @$ldap['o'][0],
        "superior"  => @$ldap['secretary'][0],
        "function"  => @$ldap['employeetype'][0],
        "active"    => (strpos(@$ldap['sambaacctflags'][0] ?? '', 'D') == false)
      ]);
    }

    public function ldap_authenticate($dn, $password)
    {
      $connection = $this->connection();
      if (@ldap_bind($connection, $dn, $password) == TRUE) {
        ldap_unbind($connection);
        return TRUE;
      }

      return FALSE;
    }

    public function ldap_user() {
      if ($this->ldap_user_cache == NULL) {
        if ($this->ldap) {
          $connection = $this->connection();
          $ous = preg_split('/ +/', getenv('LDB_LDAP_OUS'));
          ldap_set_option($connection, LDAP_OPT_PROTOCOL_VERSION, 3);
          ldap_set_option($connection, LDAP_OPT_REFERRALS, 0);
          ldap_bind($connection, getenv('LDB_LDAP_BIND_USER'), getenv('LDB_LDAP_BIND_PASS'));
          
          $todo = [];
          if (!preg_match('/@/', $this->mail)) {
            $domains = preg_split('/ +/', getenv('LDB_LDAP_MAIL_DOMAINS'));
            foreach ($domains as $domain) {
              $todo[] = $this->mail.'@'.$domain;
            }
          } else {
            $todo = [$this->mail];
          }

          foreach($ous as $ou) {
            foreach ($todo as $mail) {
              $search = ldap_search(
                $connection,
                $ou.','.getenv('LDB_LDAP_BASE_DN'),
                '(mailprimaryaddress='.$mail.')',
                $this->attribs()
              );
              $result = ldap_get_entries($connection, $search);
                    
              if ($result["count"] > 0) {
                $this->ldap_user_cache = $this->ldap_to_array($result[0]);
                ldap_unbind($connection);
                return $this->ldap_user_cache;
              }
            }
          }

          $this->ldap_user_cache = FALSE;
          ldap_unbind($connection);
        }
      }

      return $this->ldap_user_cache;
    }

    public function connection()
    {
      return ldap_connect(getenv('LDB_LDAP_HOST'), getenv('LDB_LDAP_PORT'));
    }

    public function attribs() {
      return [
        'univentionobjecttype', 'uid', 'mailprimaryaddress', 'cn', 'dn', 'o', 
        'sn', 'employeeType', 'title', 'givenname', 'secretary', 'employeetype',
        'street'
      ];
    }
  }
?>