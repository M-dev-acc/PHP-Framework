<?php

declare(strict_types=1);

namespace App\Config;

use App\Middlewares\{
    TemplateDataMiddleware, 
    ValidationExceptionMiddleware,
    SessionMiddleaware
};
use Framework\App;

function registerMiddleware(App $app) {
    $app->addMiddleware(TemplateDataMiddleware::class);
    $app->addMiddleware(ValidationExceptionMiddleware::class);
    $app->addMiddleware(SessionMiddleaware::class);
}

