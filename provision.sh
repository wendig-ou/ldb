#!/bin/bash -e

function base {
  apt-get -y update
  apt-get -y upgrade

  apt-get install -y \
    mariadb-server mariadb-client php-cli php-mysql php-ldap php-zip \
    pkg-php-tools php-xml php-mbstring php-curl curl

  # disable strict mode
  echo "[mysqld]" >> /etc/mysql/mariadb.conf.d/51-mode.cnf
  echo "sql_mode=NO_ENGINE_SUBSTITUTION" >> /etc/mysql/mariadb.conf.d/51-mode.cnf
  systemctl restart mariadb

  # legacy modules unavailable through apt
  pecl channel-update pecl.php.net
  pecl install mcrypt

  # set user=root and password=root
  SQL="UPDATE mysql.user SET plugin='', host='%' WHERE user='root';"
  SQL="${SQL} UPDATE mysql.user SET password=PASSWORD('root') WHERE user='root';"
  SQL="${SQL} FLUSH PRIVILEGES;"
  mysql -e "$SQL"

  cd /tmp
  curl -s http://getcomposer.org/installer | php
  mv composer.phar /usr/local/bin/composer

  apt-get install -y zip libgconf-2-4 chromium-browser chromium-chromedriver
  cp /vagrant/chromedriver.service /etc/systemd/system/chromedriver.service
  systemctl enable chromedriver
  systemctl start chromedriver
}

function apache {
  apt-get install -y apache2 libapache2-mod-php
  a2enmod rewrite ssl
  a2dissite 000-default
  a2ensite default-ssl
  systemctl restart apache2

  echo "configure AllowOverride all"
  echo "run setup.sh with dump.sql"
}

$1
