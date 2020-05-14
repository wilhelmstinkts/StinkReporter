docker run -v "%cd%\infrastructure\sql":/commands --rm -d --name mysql -e MYSQL_ROOT_PASSWORD=totallyunsafe mysql:5.7.28
docker exec -it mysql mysql -uroot -ptotallyunsafe --execute="\. /commands/create_tables.sql"
docker run --name myadmin -d --link mysql:db -p 2000:80 phpmyadmin/phpmyadmin
