<?php

namespace App\Kernel\Router;

#[\Attribute]
class RouteAttribute
{
    public function __construct(
        public string $method,
        public string $path
    ) {}
}
