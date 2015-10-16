sudo -i -u postgres
psql --username=postgres -c "CREATE USER iastracker"
psql --username=postgres -f preInstall.sql
cd ../web
php artisan migrate