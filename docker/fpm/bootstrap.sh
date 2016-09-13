#!/bin/bash

cd /var/app/current/src

# Install dependencies
curl -sS https://getcomposer.org/installer | php
php composer.phar install

exec /opt/remi/php70/root/usr/sbin/php-fpm --nodaemonize