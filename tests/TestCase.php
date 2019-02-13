<?php

namespace RevoSystems\iOSPassKit\Tests;

use Dotenv\Dotenv;
use ReflectionClass;
use RevoSystems\iOSPassKit\iOSPassKitServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->loadLaravelMigrations();
        $this->loadEnv();
        $this->withFactories(__DIR__.'/../database/factories');
    }

    protected function loadEnv()
    {
        return (new Dotenv(__DIR__, "../.env"))->load();
    }

    protected function getPackageProviders($app)
    {
        return [iOSPassKitServiceProvider::class];
    }

    protected function callObjectMethod($object, $method, $attributes = [])
    {
        $method = $this->getMethod($method, get_class($object));
        return $method->invokeArgs($object, $attributes);
    }

    protected function getMethod($methodName, $className)
    {
        $class = new ReflectionClass($className);
        $method = $class->getMethod($methodName);
        $method->setAccessible(true);
        return $method;
    }
}