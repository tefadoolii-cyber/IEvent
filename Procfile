release: mkdir -p storage/framework/cache/data storage/framework/sessions storage/framework/views storage/logs storage/app/public bootstrap/cache && chmod -R 775 storage bootstrap/cache && php artisan storage:link --force && php artisan migrate --force
web: php artisan serve --host=0.0.0.0 --port=${PORT:-8080}
