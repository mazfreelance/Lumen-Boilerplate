<?php

namespace App\Ship\Loaders;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Laravel\Lumen\Routing\Router;

class RouteLoader
{
    public static function register(Router $router, string $version)
    {
        $basePath = base_path("app/Containers/{$version}");
        $containerPaths = File::directories($basePath);

        $router->group(['prefix' => $version], function () use ($router, $version, $containerPaths) {
            foreach ($containerPaths as $containerPath) {
                $containerName = basename($containerPath);
                $routePath = "{$containerPath}/Routes/route.php";
                $routePrefix = Str::kebab($containerName).'s';
                $routeName = Str::kebab($containerName);
                $controllerNamespace = "App\\Containers\\{$version}\\{$containerName}\\Controllers";

                if (!File::exists($routePath)) {
                    continue;
                }

                $router->group(['namespace' => $controllerNamespace, 'prefix' => $routePrefix, 'as' => $routeName], function ($router) use ($routePath) {
                    require $routePath;
                });
            }
        });
    }
}
