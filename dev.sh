#!/bin/bash -e

USER=$(whoami)
if [ "$USER" == "vagrant" ]; then
  cd public
  php -S 0.0.0.0:3000
else
  vagrant ssh -c "cd /vagrant && ./dev.sh"
fi


