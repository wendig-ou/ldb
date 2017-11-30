#!/bin/bash -e

ROOT="$( cd "$( dirname "$0" )" && pwd )"

cd $ROOT
php public/index.php User_Sync index