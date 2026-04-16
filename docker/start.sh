#!/bin/sh
set -e

echo "==> Iniciando INVETI..."

# Crear directorios necesarios
mkdir -p /var/log/supervisor
mkdir -p storage/logs storage/framework/cache storage/framework/sessions storage/framework/views
chown -R www-data:www-data storage bootstrap/cache

# Optimizar Laravel para producción
echo "==> Optimizando Laravel..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Ejecutar migraciones
echo "==> Ejecutando migraciones..."
php artisan migrate --force

echo "==> Lanzando servicios..."
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
