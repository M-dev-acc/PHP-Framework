<?php

declare(strict_types=1);

require __DIR__ . "/../../vendor/autoload.php";

use Framework\App;
use function App\Config\{registerRoutes, registerMiddleware};
use App\Config\Path;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(Path::ROOT);

$app = new App(Path::SOURCE . "App/container-definitions.php");

registerRoutes($app);
registerMiddleware($app);

return $app; 