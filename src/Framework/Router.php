<?php

declare(strict_types=1);

namespace Framework;

class Router
{
    private array $routes = [];
    private array $middlewares = [];

    public function add(string $method, string $path, array $controller): void
    {
        $path = $this->normalizePath($path);
        $this->routes[] = [
            'path' => $path,
            'method' => strtoupper($method),
            'controller' => $controller,
        ];
    }

    public function normalizePath(string $path): string
    {
        $path = trim($path, '/');
        $path = "/{$path}/";
        $path = preg_replace('#[/]{2,}#', '/', $path);

        return $path;
    }

    public function dispatch(string $path, string $method, ?Container $container = null): void
    {
        $path = $this->normalizePath($path);
        $method = strtoupper($method);

        foreach ($this->routes as $route) {
            if (
                !preg_match("#^{$route['path']}$#", $path) ||
                $route['method'] !== $method
            ) {
                continue;
            }
            [$class, $function] = $route['controller'];
            $controller = $container ? $container->resolve($class) : new $class();
            $parameters = [];

            $action = fn () => call_user_func_array([$controller, $function], $parameters);
            foreach ($this->middlewares as $middleware) {
                $middlewareInstance = $container
                    ? $container->resolve($middleware)
                    : new $middleware();
                $currentAction = $action;
                $action = fn () => $middlewareInstance->process($currentAction);
            }

            $action();

            return;
        }

        http_response_code(404);
    }

    public function addMiddleware(string $middleware): void
    {
        $this->middlewares[] = $middleware;

    }
}
