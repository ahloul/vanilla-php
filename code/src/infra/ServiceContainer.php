<?php
namespace App\infra;
use ReflectionClass;

class ServiceContainer
{
    protected $bind = [];

    /**
     *@ param string $abstract class ID, interface
     *@ param string $concrete class to bind
     */
    public function bind($abstract, $concrete)
    {
        $this->bind[$abstract] = $this->build($concrete);
    }

    public function make($abstract)
    {
        if (!isset($this->bind[$abstract])) {
            $this->bind($abstract, $abstract);
        }
        return $this->bind[$abstract];
    }


    /**
     * @throws \ReflectionException
     */
    public function build($abstract)
    {
        $reflect = new ReflectionClass($abstract);
        $constructor = $reflect->getConstructor();
        if (is_null($constructor)) {
            return $reflect->newInstance();
        }
        $instances = $this->getParameters($constructor);
        return $reflect->newInstanceArgs($instances);
    }

    protected function getParameters($constructor)
    {
        $parameters = $constructor->getParameters();
        $dependencies = [];
        foreach ($parameters as $parameter) {
            $dependencies[] = $this->make($parameter->getClass()->name);
        }
        return $dependencies;
    }
}

