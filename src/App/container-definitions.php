<?php

declare(strict_types=1);

use App\Config\Path;
use App\Services\{
    ValidatorService,
    UserService
};
use Framework\{
    TemplateEngine,
    Database,
    Container
};

return [
    TemplateEngine::class => fn() => new TemplateEngine(Path::VIEW),
    ValidatorService::class => fn() => new ValidatorService(),
    Database::class => fn() => new Database(
        $_ENV['DB_DRIVER'],
        [
            'host' => $_ENV['DB_HOST'],
            'port' => $_ENV['DB_PORT'],
            'dbname' => $_ENV['DB_NAME'],
        ],
        $_ENV['DB_USERNAME'],
        $_ENV['DB_PASSWORD']
    ),
    UserService::class => function (Container $container) {
        $db = $container->get(Database::class);

        return new UserService($db);
    }
];
