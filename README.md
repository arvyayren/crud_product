
## Installation

* Create database
* Rename .env.example to .env
* Configure database connection in .env

Run this command for installation in project folder

```bash
composer update
php artisan key:generate
php artisan migrate
npm install
```

Run this comman to launch application

```bash
php artisan serve
npm run dev
```