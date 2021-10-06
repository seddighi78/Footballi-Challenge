# Footballi Challenge

### Code challenge of Backend Position at Oddrun company.

----------

# Getting started

## Installation

Please check the official laravel installation guide for server requirements before you start. [Official Documentation](https://laravel.com/docs/8.x/installation)

Alternative installation is possible without local dependencies relying on [Docker](#docker).

Clone the repository

    git clone git@github.com:seddighi78/Footballi-Challenge.git

Switch to the repo folder

    cd Footballi-Challenge

Install all the dependencies using composer

    composer install

Copy the example env file and make the required configuration changes in the .env ([Environment variables](#environment-variables)) file

    cp .env.example .env

Generate a new application key

    php artisan key:generate

Generate a new JWT authentication secret key

    php artisan jwt:secret

Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate

Start the local development server

    php artisan serve

You can now access the server at http://localhost:8000

## Docker

To install with [Docker](https://www.docker.com), run following commands:

```
git clone git@github.com:seddighi78/Footballi-Challenge.git
cd Footballi-Challenge
cp .env.example .env
composer install
vendor/bin/sail up -d
vendor/bin/sail artisan key:generate
vendor/bin/sail artisan jwt:secret
vendor/bin/sail artisan migrate
```

The api can be accessed at [http://127.0.0.1:8000/api](http://localhost:8000/api).

## API Documentation

This application use Postman for documentation

> [API Documentation](https://documenter.getpostman.com/view/2161256/UUy66QMS)

----------

# Code overview

## Dependencies

- [jwt-auth](https://github.com/tymondesigns/jwt-auth) - For authentication using JSON Web Tokens


## Environment variables

- `.env` - Environment variables can be set in this file

#### JWT Auth
`JWT_SECRET` It is the secret of jwt tokens.

#### GitHub Variables
`GITHUB_API_PREFIX_URL` It is the URL prefix of all GitHub requests.


***Note*** : You can quickly set the database information and other variables in this file and have the application fully working.

----------

# Testing (Docker)

Run the laravel development server

    vendor/bin/sail up -d

Then you can run the PHPUnit test

    vendor/bin/sail test

----------

# Authentication

This applications uses JSON Web Token (JWT) to handle authentication. The token is passed with each request using the `Authorization` header with `Token` scheme. The JWT authentication middleware handles the validation and authentication of the token. Please check the following sources to learn more about JWT.

- https://jwt.io/introduction/
- https://self-issued.info/docs/draft-ietf-oauth-json-web-token.html
