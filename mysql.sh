#!/bin/bash -e

USER=$(whoami)
if [ "$USER" == "vagrant" ]; then
  mysql -u root -proot ldb
else
  vagrant ssh -c "/vagrant/mysql.sh"
fi
