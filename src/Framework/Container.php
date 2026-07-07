<?php

declare(strict_types=1);

namespace Framework;

use ReflectionClass;
use ReflectionNamedType;
use Framework\Exceptions\ContainerExceptions;

class Container
{
    private array $definitions = [];
    private array $resolved = [];

    public function addDefinitions(array $definitions): void
    {
        $this->definitions = [...$this->definitions, ...$definitions];
    }

    public function resolve(string $className): object
    {
        $reflectionClass = new ReflectionClass($className);
        if (!$reflectionClass->isInstantiable()) {
            throw new ContainerExceptions("Class {$className} is not instantiable.");
        }
        $constructor = $reflectionClass->getConstructor();

        if (!$constructor) {
            return new $className();
        }

        $params = $constructor->getParameters();

        if (count($params) === 0) {
            return new $className();
        }

        $dependancies = [];

        foreach ($params as $param) {
            $name = $param->getName();
            $type = $param->getType();

            if (!$type) {
                throw new ContainerExceptions("Failed to resolve class {$className} because param {$name} is missing a type hint.");
            }

            if (!$type instanceof ReflectionNamedType || $type->isBuiltin()) {
                throw new ContainerExceptions("Failed to resolve class {$className} because invalid param name.");
            }

            $dependancies[] = $this->get($type->getName());
        }

        return $reflectionClass->newInstanceArgs($dependancies);
    }

    public function get(string $id): mixed
    {
        if (!array_key_exists($id, $this->definitions)) {
            throw new ContainerExceptions("Class {$id} does not exists in container.");
        }

        if (array_key_exists($id, $this->resolved)) {
            return $this->resolved[$id];
        }

        $factory = $this->definitions[$id];
        $dependancy = $factory();

        $this->resolved[$id] = $dependancy;

        return $dependancy;
    }
}
