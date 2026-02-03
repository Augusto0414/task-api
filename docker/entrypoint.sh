#!/bin/sh
set -e

# Crear .env basado en variables de entorno
cat > /var/www/html/.env << EOF
APP_NAME=${APP_NAME:-Laravel}
APP_ENV=${APP_ENV:-local}
APP_KEY=${APP_KEY:-base64:W9EUpabjrSEcCGyaQpJnq/vehP9DhuvbxIrUXZvPBT0=}
APP_DEBUG=${APP_DEBUG:-true}
APP_URL=${APP_URL:-http://localhost:8000}
JWT_SECRET=${JWT_SECRET:-your-secret-key}
DB_CONNECTION=${DB_CONNECTION:-pgsql}
DB_HOST=${DB_HOST:-postgres}
DB_PORT=${DB_PORT:-5432}
DB_DATABASE=${DB_DATABASE:-laravel}
DB_USERNAME=${DB_USERNAME:-root}
DB_PASSWORD=${DB_PASSWORD:-}
SESSION_DRIVER=${SESSION_DRIVER:-database}
QUEUE_CONNECTION=${QUEUE_CONNECTION:-database}
CACHE_STORE=${CACHE_STORE:-database}
EOF

# Configurar git
git config --global --add safe.directory /var/www/html

# Instalar dependencias
composer install --no-interaction --prefer-dist

# Ejecutar migraciones
php artisan migrate --force

# Ejecutar seeders
php artisan db:seed --force

# Iniciar servidor
php artisan serve --host=0.0.0.0 --port=8000
