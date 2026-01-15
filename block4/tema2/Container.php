<?php

class Container
{
    private $bindings = [];
    private $instances = [];

    public function bind($key, $resolver)
    {
        $this->bindings[$key] = $resolver;
    }

    public function singleton($key, $resolver)
    {
        $this->bindings[$key] = $resolver;
    }

    public function get($key)
    {
        if (isset($this->instances[$key])) {
            return $this->instances[$key];
        }

        if (!isset($this->bindings[$key])) {
            throw new Exception("Service {$key} not found in container");
        }

        $resolver = $this->bindings[$key];
        
        if (is_callable($resolver)) {
            $instance = $resolver($this);
        } elseif (is_string($resolver) && class_exists($resolver)) {
            $instance = $this->resolve($resolver);
        } else {
            $instance = $resolver;
        }

        $this->instances[$key] = $instance;
        
        return $instance;
    }

    private function resolve($class)
    {
        $reflection = new ReflectionClass($class);
        $constructor = $reflection->getConstructor();

        if ($constructor === null) {
            return new $class();
        }

        $parameters = $constructor->getParameters();
        $dependencies = [];

        foreach ($parameters as $parameter) {
            $type = $parameter->getType();
            
            if ($type === null) {
                throw new Exception("Cannot resolve parameter {$parameter->getName()} in {$class}");
            }

            if (!($type instanceof ReflectionNamedType)) {
                throw new Exception("Cannot resolve union or intersection type in {$class}");
            }

            $typeName = $type->getName();
            
            if ($type->isBuiltin()) {
                throw new Exception("Cannot resolve builtin type {$typeName} in {$class}");
            }

            if (interface_exists($typeName)) {
                $dependencies[] = $this->get($typeName);
            } else {
                $dependencies[] = $this->resolve($typeName);
            }
        }

        return $reflection->newInstanceArgs($dependencies);
    }
}

