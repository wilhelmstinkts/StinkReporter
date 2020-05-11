#!/bin/bash

scriptDir="$( cd "$(dirname "$0")" >/dev/null 2>&1 ; pwd -P )"
parentDir=$(dirname $scriptDir)
mountDir=${parentDir}/infrastructure/sql
docker run -v $mountDir:/commands --rm -d --name mysql -e MYSQL_ROOT_PASSWORD=totallyunsafe mysql:5.7.28
docker run --name myadmin --rm -d --link mysql:db -p 2000:80 phpmyadmin/phpmyadmin
