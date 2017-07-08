#!/bin/bash

pdo_mysql=$(php -m | grep pdo_mysql)
if [[ "$pdo_mysql" == '' ]]; then
    docker-php-ext-install pdo pdo_mysql
fi

php-fpm
