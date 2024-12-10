# Accu test - bot orders

## Test instructions

[Instructions](The%20Accu%20Bot%20Factory%20Challenge.docx)

[Order file](orders.csv)

## Set up

This guide will assume you are using a mac - using a different operating system might slightly change the set up steps.

* Install docker, git, php8.2 and composer on your machine
* Clone the repo

```sh
git clone https://github.com/jimtaylor123/accu.git 
```


* Shell into the container by moving into the project and running a few commands
```sh 
cd accu
composer install
cp .env.example .env
./vendor/bin/sail up -d
./vendor/bin/sail shell
```

If you have a problem with the MySql container it might be because you have previously run laravel using sail, so run the following commands and then repeat the step above:

```
docker-compose down --volumes
```

From here on all commands should be run in the container, not directly on your machine.

* Connect to db

Open a connection to the mysql container using a tool like tableplus or sqlpro

Open the database called accu_test or create it if it isn't present

* Install dependencies, populate .env file

```
composer install
php artisan key:generate
```

* Run commands to set up database - NB you will require an internet connection for this to work and this step might take 5 minutes
```
php artisan migrate
php artisan db:seed
php artisan app:fetch-products
php artisan app:import-csv-order-items
```
* Install npm packages and run dev server
```sh
npm install
npm run dev
``` 

* Go to http://localhost in a browser (NB not https)
* Log in by clicking "login" and using email `jim@jimtaylor.co.uk` and password `Password123`

You should now be able to see and search a list of orders. Clicking on the "View" button should take you to a page where you can view the order in detail and view its order items.

NB in real app you would set scheduler to run cron job each hour

## Possible improvements
* Add server side search, sorting and pagination to the list tables
* Move the order list to a separate page, not the dashboard
* Write a few feature tests
* Implement a real queue instead of using sync
