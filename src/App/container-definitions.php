<?php

declare(strict_types=1);

use App\Config\Path;
use App\Services\ValidatorService;
use Framework\Database;
use Framework\TemplateEngine;

return [
    TemplateEngine::class => fn () => new TemplateEngine(Path::VIEW),
    ValidatorService::class => fn () => new ValidatorService(),
    Database::class => fn () => new Database(
        'mysql',
        [
            'host' => "localhost",
            'port' => 3306,
            'dbname' => 'basic_framework',
        ],
        'root',
        ''
    ),
];
