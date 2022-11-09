<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## Custom JWT autentication with jwt-php package and http only cookies, integrated with swagger

#

### Prerequisites

-   *PHP@8.0 and up*
-   _MYSQL@8 and up_
-   _npm@8 and up_
-   _composer@2 and up_

#

### Getting Started

<br>

```sh
git clone https://github.com/David-Buchukuri/laravel-php-jwt-example
```

<br>

```sh
composer install
```

<br>

```sh
npm install
```

<br>

4\. Now we need to set our env file. Go to the root of your project and execute this command.

```sh
cp .env.example .env
```

<br>

```sh
php artisan key:generate
```

<br>

And now you should write inside of a **.env** file all necessary environment variables:

#

**MYSQL:**

<br>

> DB_CONNECTION=mysql

> DB_HOST=127.0.0.1

> DB_PORT=3306

> DB_DATABASE=

> DB_USERNAME=

> DB_PASSWORD=

<br>

**JWT:**

<br>

> JWT_SECRET=

> FRONT_TOP_LEVEL_DOMAIN=

<br>

### setting jwt secret

you can open tinker shell with a command
<br>
`php artisan tinker`
<br>
generate random string there and set it as a JWT_SECRET
<br>
`Str::random(120)`
<br>

### setting front end top level domain

if you want to run this project locally, your domain most likely will be `127.0.0.1`

if you want to run this project in production, make sure to put here, the top level domain of your front end

<br>

#

### Migration

<br>

```sh
php artisan migrate
```

<br>

#

### Development

<br>

You can run Laravel's built-in development server by executing:

```sh
  php artisan serve
```

<br>

when working on swagger:

```sh
  npm run dev
```

#
