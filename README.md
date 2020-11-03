# vue-laravel-large-xml-upload

Vue 2.6 + Laravel 8 + PHP 7.3 + Axios xml upload example app

### Installation

1. Clone repo

2. Change to directory

````
cd laravel_xml_upload
````   

3. Install dependencies

````
composer install
````

4. Copy .env file

```
cp .env.example .env
```

5. Modify `DB_*` value in `.env` with your database config.

6. Generate application key:

````
php artisan key:generate
````

7. Migrate
````
php artisan migrate
````

8. Install Node modules
````
npm install
````

9. Build

````
npm run prod
````
