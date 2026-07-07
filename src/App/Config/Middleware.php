<?php

declare(strict_types=1);

namespace App\Config;

use App\Middlewares\{
    FlashMiddleware,
    TemplateDataMiddleware,
    ValidationExceptionMiddleware,
    SessionMiddleaware
};
use Framework\App;

function registerMiddleware(App $app)
{
    $app->addMiddleware(TemplateDataMiddleware::class);
    $app->addMiddleware(ValidationExceptionMiddleware::class);
    $app->addMiddleware(FlashMiddleware::class);
    $app->addMiddleware(SessionMiddleaware::class);
}
