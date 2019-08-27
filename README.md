# Laravel Rest API UK Task Application

The purpose of this repository is to provide API with [Laravel 5.8](http://laravel.com/), and is an implementation of this code challenge [github.com/holidayextras/culture/blob/master/recruitment/developer-API-task](https://github.com/holidayextras/culture/blob/master/recruitment/developer-API-task.md). 

You can connecting JavaScript front-end frameworks like [ReactJS](https://reactjs.org) or other clients to them.


Beside Laravel, this project uses other tools like :

- [tymon/jwt-auth](https://github.com/tymondesigns/jwt-auth)
- [spatie/laravel-cors](https://github.com/spatie/laravel-cors)
- [webpatser/laravel-uuid](https://github.com/webpatser/laravel-uuid)

## Installation

Development environment requirements :
- [Docker](https://www.docker.com) >= 17.06 CE
- [Docker Compose](https://docs.docker.com/compose/install/)

Setting up your development environment on your local machine :
```
$ git clone https://github.com/galter/laravel-api-crud-uk-task.git
$ cd laravel-api-crud-uk-task
$ cp .env.example .env
$ docker-compose run --rm --no-deps api-uk-server composer install
$ docker-compose run --rm --no-deps api-uk-server php artisan key:generate
$ docker-compose run --rm --no-deps api-uk-server php artisan jwt:secret
$ docker-compose up -d
```

## Before starting
You need to run the migrations :
```
$ docker-compose run --rm api-uk-server php artisan migrate
```

Seed the database :
```
$ docker-compose run --rm api-uk-server php artisan db:seed
```

This will create a default user that you can use to sign in :
```
Email : bilbo@baggins.uk
Password : _my_pr3c10u5_
```

## Useful commands
Running tests :
```
$ docker-compose run --rm api-uk-server ./vendor/bin/phpunit --cache-result --order-by=defects --stop-on-defect
```

Discover package
```
$ docker-compose run --rm --no-deps api-uk-server php artisan package:discover
```

Generating fake data :
```bash
$ docker-compose run --rm api-uk-server php artisan db:seed --class=DevDatabaseSeeder
```

## Accessing the API

Clients can access to the REST API. API requests require authentication via JWT. You can create a new one with you credentials.

```bash
$ curl -X POST http://localhost:8000/api/v1/auth/login -d "email=your_email&password=your_password"
```

Then, you can use this token either as url parameter or in Authorization header :

```bash
# Url parameter
curl -X POST http://localhost:8000/api/v1/auth/me?token=your_jwt_token_here

# Authorization Header
curl -X POST --header "Authorization: Bearer your_jwt_token_here" http://localhost:8000/api/v1/auth/me
```

API are prefixed by ```api``` and the API version number like so ```v1```.

Do not forget to set the ```X-Requested-With``` header to ```XMLHttpRequest```. Otherwise, Laravel won't recognize the call as an AJAX request.

To list all the available routes for API :

```bash
$ docker-compose run --rm --no-deps api-uk-server php artisan route:list
```

## Consume the API

The documentation is available in [SwaggerHub / uk-Recruiment-api](https://app.swaggerhub.com/apis-docs/galter/uk-recruiment-api-laravel/1.0.0) 

You can consume the API with any client.

## Contributing

Do not hesitate to contribute to the project by adapting or adding features ! Bug reports or pull requests are welcome.

## Authors

* **Cicero Galter** -  [Galter](https://github.com/galter)

## License

This project is released under the [MIT](http://opensource.org/licenses/MIT) license.