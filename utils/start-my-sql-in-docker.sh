#!/bin/bash
docker run -d --name mysql -e MYSQL_ROOT_PASSWORD=totallyunsafe mysql:5.7.28
docker run --name myadmin -d --link mysql:db -p 8080:80 phpmyadmin/phpmyadmin
