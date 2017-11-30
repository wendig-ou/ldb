#!/bin/bash -e

# structure only:
mysqldump -d -h localhost -u root -proot ldb > structure.sql

# include data:
# mysqldump -h localhost -u root -proot ldb > structure.sql