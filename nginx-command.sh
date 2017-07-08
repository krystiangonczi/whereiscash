#!/bin/bash

if [[ ! -e '/var/share/php-socket/php-fpm.sock' ]]; then
    sleep 30
fi

echo "ok"

chmod 666 /var/share/php-socket/php-fpm.sock
nginx -g "daemon off;"
