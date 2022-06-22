<?php

namespace App\Ship\Support;

/**
 * Executor
 *
 * @method static void setApiVersion(string $version)
 * @method static string getApiVersion()
 * @method mixed run(string $class, ...$args)
 */
class Executor
{
    public static $apiVersion;

    /**
     * Set Api Version
     *
     * @static
     * @param string $apiVersion
     * @return void
     */
    public static function setApiVersion(string $apiVersion): void
    {
        self::$apiVersion = $apiVersion;
    }

    /**
     * Get Api Version
     *
     * @static
     * @return string
     */
    public static function getApiVersion(): string
    {
        return self::$apiVersion;
    }

    /**
     * Run
     *
     * @codeCoverageIgnore
     * @param string $class
     * @param mixed ...$args
     * @return array|string|void
     */
    public function run(string $class, ...$args)
    {
        $class = $this->resolveClass($class);

        return $class->execute(...$args);
    }

    /**
     * Resolve Class
     *
     * @codeCoverageIgnore
     * @param string $class
     * @return mixed
     */
    private function resolveClass(string $class)
    {
        $apiVersion = self::$apiVersion;
        $parsedClass = explode('@', $class);
        list($containerName, $className) = $parsedClass;

        $containerPath = "\\App\\Containers\\{$apiVersion}\\{$containerName}";
        $class = "{$containerPath}\\Actions\\{$className}";

        $this->checkClassExists($class, $className);

        return new $class;
    }

    /**
     * Check Class Exists
     *
     * @codeCoverageIgnore
     * @param string $class
     * @param string $className
     * @return void
     * @throws \Exception
     */
    private function checkClassExists(string $class, string $className): void
    {
        if (!class_exists($class)) {
            throw new \Exception("{$className} action not found.");
        }
    }
}
