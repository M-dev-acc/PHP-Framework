<?php
declare(strict_types=1);

use App\Config\Path;
use App\Services\ValidatorService;
use Framework\TemplateEngine;

return [
    TemplateEngine::class => fn () => new TemplateEngine(Path::VIEW),
    ValidatorService::class => fn () => new ValidatorService(),
];