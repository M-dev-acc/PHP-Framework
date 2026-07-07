<?php

declare(strict_types=1);

if (!function_exists('dd')) {
    function dd(mixed ...$vars): never
    {
        foreach ($vars as $value) {
            echo "<pre>";
            var_dump($value);
            echo "</pre>";
        }
        die;
    }
}
