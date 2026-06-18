<?php

declare(strict_types=1);

namespace App\Config;

use App\Middlewares\TemplateDataMiddleware;
use Framework\App;

function registerMiddleware(App $app) {
    $app->addMiddleware(TemplateDataMiddleware::class);
}

