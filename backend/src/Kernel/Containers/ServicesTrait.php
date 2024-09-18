<?php

namespace App\Kernel\Containers;

use ReflectionClass;
use ReflectionException;
use ReflectionParameter;

trait ServicesTrait
{
    private array $services;
    private $bindings = [];

    public function get($class)
    {
        if (isset($this->services[$class])) {
            return $this->services[$class];
        }

        if (isset($this->bindings[$class])) {
            $concrete = $this->bindings[$class];
            $instance = $this->build($concrete);
        } else {
            $instance = $this->build($class);
        }

        $this->services[$class] = $instance;

        return $instance;
    }
    public function bind($abstract, $concrete)
    {
        $this->bindings[$abstract] = $concrete;
    }

    private function build($class)
    {
        try {
            $reflection = new ReflectionClass($class);

            if (!$reflection->isInstantiable()) {
                throw new \Exception("Class $class is not instantiable.");
            }

            $constructor = $reflection->getConstructor();

            if (is_null($constructor)) {
                return new $class;
            }

            $parameters = $constructor->getParameters();
            $dependencies = [];

            foreach ($parameters as $parameter) {
                $dependency = $this->resolveDependency($parameter);
                $dependencies[] = $dependency;
            }

            return $reflection->newInstanceArgs($dependencies);
        } catch (ReflectionException $e) {
            throw new \Exception("Error building class $class: " . $e->getMessage());
        }
    }

    private function resolveDependency(ReflectionParameter $parameter)
    {
        $type = $parameter->getType();
        if ($type === null) {
            throw new \Exception("Cannot resolve dependency: {$parameter->getName()}");
        }

        $typeName = $type->getName();

        if ($typeName === 'self' || $typeName === 'parent') {
            $typeName = $parameter->getDeclaringClass()->getName();
        }

        if (class_exists($typeName)) {
            return $this->get($typeName);
        }

        if ($this->getEnv($parameter->getName())) {
            return $this->getEnv($parameter->getName());
        }

        throw new \Exception("Cannot resolve dependency of type: $typeName | {$parameter->getName()}");
    }
}