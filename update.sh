#!/bin/bash -e

git pull
php public/index.php migrate index up