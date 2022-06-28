# Lumen Boilerplate
- A Lumen boilerplate for quick setup and get into development asap.
- Development setup for API

## Version
- 20th June 2022 - 9.x

## Feature Include
- Reorganized app structure using [Porto (Software Architectural Pattern)](http://apiato.io/docs/9.x/getting-started/software-architectural-patterns/)
    - `Containers` (Application features/functionalities)
    - `Ship` (The Parent classes "Base classes" of the Ship layer gives full control over the Container's Components)
- Implemented [Sentry](https://sentry.io/welcome/sentry) is on a mission to help developers write better software faster, so we can get back to enjoying technology.
- Implemented supporting custom facades such as executor, responder, helper, logger
    - `Executor` (For executer function)
    - `Responder` (For respoder function)
    - `Helper` (For helper function)
    - `Logger` (For debug function)
- Implemented base login, logout, forgot and reset password, email verification, refresh token and get user information API using `Laravel Passport`
    - allow multiple login and multiple device
    - use `/v1/authentications/refresh-token` if access token expired.
    - Open the `.env` file and update the variable to your own variable and do not forget to set the following:
    ```
    ALLOW_LOGIN_MULTIPLE_TOKEN=true
    ```
    >This will be the default is false. User can login one(1) device only.
- Implemented debugging tool for developer using `Sentry`
- Implemented Import/Export to excel
- Clean controller setup
	- Controller will only inject `Action` class and should only call the `execute` method.
	- All business logic related function is handled in `Action` class
- Standardized API response which include:
	- Unauthorized request
	- Validation request
- Support API versioning

## Package Include
- Form Request
- Pusher
- Redis
- Enum
- Passport
- Eloquent Filter
- [Action & Data Transfer Object](https://github.com/mazfreelance/laravel-command-generator)
- Spatie/Slugable
- Spatie/Laravel Permission
- Sentry
- Guzzle HTTP
- Maatwebsite/excel

## Prerequisite
Fork this repository to your own repository.

## Setup Guide
Clone the forked repository to your system using GUI tools or command line 
```bash
git clone <your_repository_url> <directory_to_clone_to>
```

Copy `.env.example` and rename as a new file as `.env`

After setting your `.env` file, run: 
```bash
composer install
```

After composer install finish, run the following command to set application key.
```bash
php artisan key:generate
```

Then run migration command and seed the database.
```bash
php artisan migrate --seed
```

Next, run the following command to setup `Passport` and `Telescope`
```bash
php artisan passport:install --uuids
```

>If already setup `Passport`
* create personal client
```bash
php artisan passport:client --personal
```

## Unit Test
> all test case
```bash
vendor/bin/phpunit
```
> specific test case
* `<folder_name>` - Unit / Feature
```bash
vendor/bin/phpunit tests/<folder_name>/<class_name>
```
> specific function on test case
```bash
vendor/bin/phpunit --filter=functionName
```
