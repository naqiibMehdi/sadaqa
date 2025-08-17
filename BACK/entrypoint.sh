#!/bin/sh
service cron start

php artisan migrate:refresh --force
php artisan config:clear
php artisan cache:clear
php artisan storage:link
php artisan key:generate
php artisan scribe:generate
php artisan queue:listen
