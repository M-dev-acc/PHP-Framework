<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\Config\Path;

class HomeController
{
    public function __construct(
        private TemplateEngine $view = new TemplateEngine(Path::VIEW),
    )
    {}

    public function home() : void {
        echo $this->view->render("index.phtml", [
            'title' => "Home page",
        ]);
    }
}
