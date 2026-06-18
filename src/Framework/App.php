<?php

declare(strict_types=1);

namespace Framework;

class App
{

    public function __construct(
        ?string $contianerDefinitionsPath = null,
        private Router $router = new Router(),
        private Container $container = new Container(),
    )
    {
        if ($contianerDefinitionsPath) {
            $contianerDefinitions = include $contianerDefinitionsPath;
            $this->container->addDefinitions($contianerDefinitions);
        }
    }

    public function run() : void {
        $path = parse_url($_SERVER['REQUEST_URI'],  PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];

        $this->router->dispatch($path, $method, $this->container);
    }

    public function get(string $path, array $controller): void {
        $this->router->add('get', $path, $controller);
    }

    public function addMiddleware(string $middleware) : void {
        $this->router->addMiddleware($middleware);
    }
}
