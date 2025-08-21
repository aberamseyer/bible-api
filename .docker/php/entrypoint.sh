#!/bin/sh

# Install/update composer dependencies if composer.json exists
if [ -f "composer.json" ]; then
    composer install --no-interaction --optimize-autoloader
fi

# Execute the original command (php-fpm)
exec "$@"