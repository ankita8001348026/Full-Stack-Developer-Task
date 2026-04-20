## Required platform

-   PHP 8.0
-   MySQL
-   Composer
-   Docker (optional)

## How to setup project?

##### Follow below steps:

-   If windows run `copy .env.example .env` else `cp .env.example .env`
-   create database and set database credentials on `.env` file
-   Run `composer i`
-   Run `php artisan key:generate`
-   Run `php artisan storage:link`
