#!/bin/bash -e

if [ -f .env ]; then
  source .env
fi

MYARGS="-h $LDB_DB_HOST -P $LDB_DB_PORT -u $LDB_DB_USER -p$LDB_DB_PASS"

mysql $MYARGS -e "DROP DATABASE $LDB_DB" || true
mysql $MYARGS -e "CREATE DATABASE $LDB_DB character set utf8 COLLATE utf8_general_ci"

mysql $MYARGS -e "DROP DATABASE ldb_test" || true
mysql $MYARGS -e "CREATE DATABASE ldb_test character set utf8 COLLATE utf8_general_ci"

if [ -f dump.sql ]; then
  cat dump.sql | \
    replace CHARSET=latin1 CHARSET=utf8 | \
    replace latin1_general_ci utf8_general_ci | \
    mysql $MYARGS $LDB_DB
fi

php public/index.php migrate index up
