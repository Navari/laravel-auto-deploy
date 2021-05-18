#!/usr/bin/env bash

# shutdown the application
php artisan down
#pull update from Git
git pull
# Update dependencies again
composer update
# run autoload
composer dump-autoload
#clear config cache
php artisan config:cache
# run migration forcefully.
php artisan migrate --force
# Now, power on the application
php artisan up
