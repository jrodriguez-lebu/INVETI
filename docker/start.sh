#!/bin/sh
set -e

echo "==> Iniciando INVETI..."

# ── Directorios y permisos ────────────────────────────────────────────────────
mkdir -p /var/log/supervisor
mkdir -p storage/logs \
         storage/framework/cache \
         storage/framework/sessions \
         storage/framework/views \
         bootstrap/cache

chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

# ── Esperar a que MySQL esté disponible ───────────────────────────────────────
echo "==> Esperando conexión a la base de datos..."
MAX_TRIES=30
TRIES=0
until php artisan db:show --json > /dev/null 2>&1; do
    TRIES=$((TRIES + 1))
    if [ "$TRIES" -ge "$MAX_TRIES" ]; then
        echo "ERROR: No se pudo conectar a la base de datos tras $MAX_TRIES intentos."
        exit 1
    fi
    echo "   Intento $TRIES/$MAX_TRIES — esperando 3s..."
    sleep 3
done
echo "==> Base de datos lista."

# ── Optimizar Laravel ─────────────────────────────────────────────────────────
echo "==> Optimizando Laravel..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# ── Migraciones ───────────────────────────────────────────────────────────────
echo "==> Ejecutando migraciones..."
php artisan migrate --force

echo "==> Lanzando servicios (Nginx + PHP-FPM + Queue)..."
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
