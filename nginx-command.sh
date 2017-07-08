#!/bin/bash

sleep 15
echo "ok"

chmod 666 /var/share/php-socket/php-fpm.sock
nginx -g "daemon off;"
