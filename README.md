### Version
- Lumen v9

# Lumen Boilerplate
- A Lumen boilerplate for quick setup and get into development asap.
- Development setup for API

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
<!-- - Implemented base login, logout and get user information API using `Laravel Passport` -->
<!-- - Implemented debugging tool for developer using `Laravel Telescope` and with control of accessible only by specific email address -->
- Implemented debugging tool for developer using `Sentry`
- Clean controller setup
	- Controller will only inject `Action` class and should only call the `execute` method.
	- All business logic related function is handled in `Action` class
- Standardized API response which include:
	- Unauthorized request
	- Validation request
- Support API versioning

## Package Include
- Enum
- Passport
- Eloquent Filter
- [Action & Data Transfer Object](https://github.com/mazfreelance/laravel-command-generator)
- Spatie/Slugable
- Spatie/Laravel Permission
- Sentry

## Prerequisite
Fork this repository to your own repository.

## Setup Guide
Clone the forked repository to your system using GUI tools or command line 
```bash
git clone <your_repository_url> <directory_to_clone_to>
```

Copy `.env.example` and rename as a new file as `.env`

Open the `.env` file and update the variable to your own variable and do not forget to set the following:
```

```
>This will be the default admin user and developer user that will be seeded into the database.
*By default only `DEVELOPER_USER_SEED_EMAIL` can access to telescope module*

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

If already setup `Passport`
```bash
# create personal client
php artisan passport:client --personal
```

# Unit Test
```bash
vendor/bin/phpunit #all test case
vendor/bin/phpunit --filter=functionName #specific test case
```
