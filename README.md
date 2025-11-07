XAMPP CONTROL PANEL :

APACHE - START
MYSQL - START

PHP - 8.1+
COMPOSER - LATEST
MYSQL - 5.7+ MARIADB
NODE.JS - 16+ (OPTIONAL FOR UI)
LARAVEL - 12+

composer install

composer update

DB_DATABASE=race_tracker
DB_USERNAME=root
DB_PASSWORD=

php artisan key:generate

CREATE DATABASE race_tracker; // IN MYSQL CREATE DATABASE

php artisan migrate:fresh --seed

php artisan serve

# LOGIN

ADMIN

email : admin@domain.com
password : password

USER

email : user@domain.com
password : password

email : shohebkazi456@gmail.com
password : shoheb123
