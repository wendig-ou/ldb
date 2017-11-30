#!/bin/bash -e

USER=$(whoami)
if [ "$USER" == "vagrant" ]; then
  export LDB_ORIGIN="http://localhost:3999"
  export LDB_DB="ldb_test"
  cd public
  php -S 0.0.0.0:3999
else
  vagrant ssh -c "cd /vagrant && ./test.sh"
fi

