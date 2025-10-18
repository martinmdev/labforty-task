Labforty task
==============

Clone with
```
git clone git@github.com:martinmdev/labforty-task.git
```

Change directory
```
cd labforty-task
```

Copy .env.example into .env
```
cp .env.example .env
```

Open .env and change the DB_* variables to match your mysql server settings 

Run
```
composer install
npm install
npm run build
php artisan key:generate
php artisan migrate
php artisan db:seed --class=NotificationTypeSeeder
```

Start with
```
composer run dev
```

Access at http://127.0.0.1:8000/
