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
echo "==> Esperando conexión a MySQL en ${DB_HOST}:${DB_PORT}..."
MAX_TRIES=30
TRIES=0
until php -r "
    try {
        \$pdo = new PDO(
            'mysql:host=${DB_HOST};port=${DB_PORT};dbname=${DB_DATABASE}',
            '${DB_USERNAME}',
            '${DB_PASSWORD}',
            [PDO::ATTR_TIMEOUT => 3]
        );
        echo 'OK';
    } catch (Exception \$e) {
        echo 'FAIL: ' . \$e->getMessage();
        exit(1);
    }
" 2>/dev/null | grep -q 'OK'; do
    TRIES=$((TRIES + 1))
    if [ "$TRIES" -ge "$MAX_TRIES" ]; then
        echo "ERROR: No se pudo conectar a MySQL tras $MAX_TRIES intentos."
        echo "  DB_HOST=${DB_HOST}"
        echo "  DB_PORT=${DB_PORT}"
        echo "  DB_DATABASE=${DB_DATABASE}"
        echo "  DB_USERNAME=${DB_USERNAME}"
        exit 1
    fi
    echo "   Intento $TRIES/$MAX_TRIES — reintentando en 3s..."
    sleep 3
done
echo "==> MySQL listo."

# ── Optimizar Laravel ─────────────────────────────────────────────────────────
echo "==> Cacheando configuración..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# ── Migraciones ───────────────────────────────────────────────────────────────
echo "==> Ejecutando migraciones..."
php artisan migrate --force

echo "==> Lanzando servicios (Nginx + PHP-FPM + Queue)..."
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
