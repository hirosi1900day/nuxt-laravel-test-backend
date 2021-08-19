# docker-laravel-demo

```
$ git clone https://github.com/hirosi1900day/docker-laravel.git
$ cd docker-laravel-demo
$ docker-compose up -d --build
$ docker-compose exec app bash
$ composer install
$ cp .env.example .env
$ php artisan key:generate
$ php artisan migrate
$ exit
```

[http://127.0.0.1:8080](http://127.0.0.1:8080)
