<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Kernel\Containers\Container;
use App\Kernel\Router\Router;

$container = new Container();
$container->boot(
    controllersDirectory: __DIR__ . '/src/Controller',
    envDirectory: __DIR__ . '/.env'
);

echo Router::get($container);
