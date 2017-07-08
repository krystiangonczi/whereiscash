#!/usr/bin/env bash

docker run \
    --name wykop_db \
    -e MYSQL_ROOT_PASSWORD=root123 \
    -e MYSQL_RANDOM_ROOT_PASSWORD=yes \
    -e MYSQL_DATABASE=wykop_db \
    -e MYSQL_USER=wykop_user \
    -e MYSQL_PASSWORD=wykop_password \
    -p 33060:3306 \
    -v "$(pwd)":/app \
    -d \
    mariadb:10.1.17

# docker-compose exec db bash -c 'mysql -u wykop_user -pwykop_password wykop_db < /app/schema.sql'
#

cd web/
php -S localhost:8000

docker stop wykop_db
docker rm -v wykop_db
