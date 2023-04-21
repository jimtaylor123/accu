# Accu test - bot orders

## Set up

install docker on your machine

git clone repo
cd accu-test
./vendor/bin/sail up
./vendor/bin/sail shell

connect to db
create table in db called accu_test

composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed

go to localhost
log in using jim@jimtaylor.co.uk and password Password123

NB in real app you would set scheduler to run cron job each hour

php artisan app:fetch-products
php artisan app:import-csv-order-items

// BLITZ
php artisan migrate:fresh && \
php artisan db:seed && \
php artisan app:fetch-products && \
php artisan app:import-csv-order-items