# Employee List

Installing instructions are below.

## Install
Rename .env.example as .env and set DB settings, also UPLOAD_PHOTO_PATH (it's "/uploads/" as default).
Ps. Give writing permission /public/uploads , in case.
```
composer install
npm install && npm run dev
php artisan migrate
```

## Test

```
php artisan test
```
