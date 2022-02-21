## Create project
curl -s "https://laravel.build/example-app?with=mysql" | bash

## Run
vendor/bin/sail up

## Shutdown
vendor/bin/sail down

## Crate Table Examples
vendor/bin/sail artisan make:migration create_categories_table
vendor/bin/sail artisan make:migration create_customers_table

## Run Migrate
vendor/bin/sail artisan migrate
