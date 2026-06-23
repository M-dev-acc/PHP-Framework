<?php

declare(strict_types=1);


if (!function_exists('redirect')) {
    function redirect(string $url) : void {
        header("Location: $url");
        http_response_code(302);
        exit;
    }    
}
