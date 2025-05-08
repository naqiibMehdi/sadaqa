#!/bin/sh
php artisan migrate:refresh --seed --force
php artisan config:clear
php artisan cache:clear
php artisan storage:link
php artisan scribe:generate
php artisan queue:listen
