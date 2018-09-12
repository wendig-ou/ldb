#!/bin/bash -e

function base {
  apt-get -y update
  apt-get -y upgrade

  apt-get install -y \
    mariadb-server mariadb-client php-cli php-mysql php-ldap php-zip php-mcrypt \
    php-xml php-mbstring php-curl curl

  SQL="UPDATE mysql.user SET plugin='', host='%' WHERE user='root';"
  SQL="${SQL} UPDATE mysql.user SET password=PASSWORD('root') WHERE user='root';"
  SQL="${SQL} FLUSH PRIVILEGES;"

  mysql -e "$SQL"

  cd /tmp
  curl -s http://getcomposer.org/installer | php
  mv composer.phar /usr/local/bin/composer

  apt-get install -y zip libgconf-2-4 chromium-browser
  cd /opt
  wget https://chromedriver.storage.googleapis.com/2.41/chromedriver_linux64.zip
  unzip chromedriver_linux64.zip
  ln -sfn /opt/chromedriver /usr/bin/chromedriver
  rm chromedriver_linux64.zip

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