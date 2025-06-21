# How to run the application?
## Prerequisities
1. Ensure you have `php` and `composer` installed

## How to setup the app?
1. Clone it first from here(main branch) https://github.com/romario-giacholari/gambling-com-dev-task
2. `cd` into `gambling-com-dev-task`
3. run `composer install`
4. run `php artisan migrate`
5. run `php artisan serve`

## How to trigger the endpoint
1. Make a `POST` request to `http://127.0.0.1:8000/api/affiliates/invite` and ensure you pass the `affiliates` file in the request (you can use **POSTMAN** and pass the file via `form-data`)

## How to run the tests?
- Simply run `php artisan test`