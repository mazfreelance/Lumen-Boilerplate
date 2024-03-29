<?php

require_once __DIR__.'/../vendor/autoload.php';

(new Laravel\Lumen\Bootstrap\LoadEnvironmentVariables(
    dirname(__DIR__)
))->bootstrap();

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| Here we will load the environment and create the application instance
| that serves as the central piece of this framework. We'll use this
| application as an "IoC" container and router for this framework.
|
*/

// $app = new Laravel\Lumen\Application(
//    dirname(__DIR__)
// );
$app = new \Dusterio\LumenPassport\Lumen7Application(
    dirname(__DIR__)
);

$app->withFacades();

$app->withEloquent();

/*
|--------------------------------------------------------------------------
| Register Container Bindings
|--------------------------------------------------------------------------
|
| Now we will register a few bindings in the service container. We will
| register the exception handler and the console kernel. You may add
| your own bindings here if you like or you can make another file.
|
*/

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Ship\Exceptions\Handler::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Ship\Console\Kernel::class
);

/*
|--------------------------------------------------------------------------
| Register Config Files
|--------------------------------------------------------------------------
|
| Now we will register the "app" configuration file. If the file exists in
| your configuration directory it will be loaded; otherwise, we'll load
| the default version. You may register other files below as needed.
|
*/

$app->configure('app');
$app->configure('auth');
$app->configure('broadcasting');
$app->configure('cache');
$app->configure('cors');
$app->configure('database');
$app->configure('excel');
$app->configure('filesystems');
$app->configure('logging');
$app->configure('mail');
$app->configure('passport');
$app->configure('permission');
$app->configure('queue');
$app->configure('services');
$app->configure('view');

config(['eloquentfilter.namespace' => "App\\Ship\\ModelFilters\\"]);
config(['custom-command.action.namespace' => "App\\Ship\\Actions\\"]);
config(['custom-command.dto.namespace' => "App\\Ship\\DTO\\"]);

/*
|--------------------------------------------------------------------------
| Register Aliases
|--------------------------------------------------------------------------
 */

$app->alias('mail.manager', Illuminate\Mail\MailManager::class);
$app->alias('mail.manager', Illuminate\Contracts\Mail\Factory::class);

$app->alias('mailer', Illuminate\Mail\Mailer::class);
$app->alias('mailer', Illuminate\Contracts\Mail\Mailer::class);
$app->alias('mailer', Illuminate\Contracts\Mail\MailQueue::class);

$app->alias('cache', \Illuminate\Cache\CacheManager::class);

/*
|--------------------------------------------------------------------------
| Register Middleware
|--------------------------------------------------------------------------
|
| Next, we will register the middleware with the application. These can
| be global middleware that run before and after each request into a
| route or middleware that'll be assigned to some specific routes.
|
*/

$app->middleware([
    App\Ship\Middleware\CheckIpAddress::class,
    App\Ship\Middleware\Localization::class,
    App\Ship\Middleware\Logger::class,
]);

$app->routeMiddleware([
    'auth' => App\Ship\Middleware\Authenticate::class,
    'client' => \Laravel\Passport\Http\Middleware\CheckClientCredentials::class,
    'permission' => Spatie\Permission\Middlewares\PermissionMiddleware::class,
    'role' => Spatie\Permission\Middlewares\RoleMiddleware::class,
    'throttle' => \LumenRateLimiting\ThrottleRequests::class,
]);

/*
|--------------------------------------------------------------------------
| Register Service Providers
|--------------------------------------------------------------------------
|
| Here we will register all of the application's service providers which
| are used to bind services into the container. Service providers are
| totally optional, so you are not required to uncomment this line.
|
*/

$app->register(Illuminate\Filesystem\FilesystemServiceProvider::class);
$app->register(Illuminate\Notifications\NotificationServiceProvider::class);
$app->register(Illuminate\Redis\RedisServiceProvider::class);
$app->register(Illuminate\Mail\MailServiceProvider::class);
$app->register(Jenssegers\Agent\AgentServiceProvider::class);
$app->register(Mazfreelance\LaravelCommandGenerator\ServiceProvider::class);
$app->register(Flipbox\LumenGenerator\LumenGeneratorServiceProvider::class);
$app->register(EloquentFilter\LumenServiceProvider::class);
$app->register(Laravel\Passport\PassportServiceProvider::class);
$app->register(Dusterio\LumenPassport\PassportServiceProvider::class);
$app->register(Spatie\Permission\PermissionServiceProvider::class);
$app->register(Spatie\LaravelData\LaravelDataServiceProvider::class);
$app->register(Anik\Form\FormRequestServiceProvider::class);
$app->register(Sentry\Laravel\ServiceProvider::class);
$app->register(Sentry\Laravel\Tracing\ServiceProvider::class);
$app->register(Maatwebsite\Excel\ExcelServiceProvider::class);
$app->register(Fruitcake\Cors\CorsServiceProvider::class);

$app->register(App\Ship\Providers\AppServiceProvider::class);
$app->register(App\Ship\Providers\AuthServiceProvider::class);
// $app->register(BroadcastServiceProvider::class);
$app->register(App\Ship\Providers\EventServiceProvider::class);

/*
|--------------------------------------------------------------------------
| Load The Application Routes
|--------------------------------------------------------------------------
|
| Next we will include the routes file so that they can all be added to
| the application. This will provide all of the URLs the application
| can respond to, as well as the controllers that may handle them.
|
*/

$app->router->get('/', function () {
    return "App is running...";
});

\Dusterio\LumenPassport\LumenPassport::routes($app);
\App\Ship\Loaders\RouteLoader::register($app->router, 'v1');

return $app;
