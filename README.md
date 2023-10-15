<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# YoPrint Assignment
## Before Start
```bash
# clone repositories
git clone https://github.com/lihshin96/yoprint-assignment.git

# Install composer vendor
composer install

# Install dependency
npm install

# generate .env key(Optional)
php artisan key:generate 

# Go in directory
cd yoprint-assignment

# Migrate database
php artisan migrate

# Start http server
php artisan serve

# Develop environment
npm run dev \ npm run watch

```

## Redis
```bash
# Start Redis Server
redis-server

```

## Horizon
```bash
# Start Horizon
php artisan horizon

```

## .env
```bash
BROADCAST_DRIVER=pusher
QUEUE_CONNECTION=redis
QUEUE_DRIVER=redis

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_APP_CLUSTER=

# Please check .env.example for more details
```

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
