<?php

namespace App\Kernel\Router;

use App\Kernel\Containers\Container;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;

class Router
{
    private array $routes = [];

    public function __construct(private Container $container)
    {
    }

    public function registerRoute(array $controllers): void
    {
        foreach ($controllers as $controllerClass) {
            $reflectionClass = new ReflectionClass($controllerClass);

            foreach ($reflectionClass->getMethods() as $method) {
                $attributes = $method->getAttributes(RouteAttribute::class);
                foreach ($attributes as $attribute) {
                    $route = $attribute->newInstance();
                    $this->routes[] = [
                        'method' => $route->method,
                        'path' => $route->path,
                        'controller' => $controllerClass,
                        'methodName' => $method->getName()
                    ];
                }
            }
        }
    }

    /**
     * @throws ReflectionException
     */
    public function dispatch(string $method, string $path)
    {
        $parsedUrl = parse_url($path);
        foreach ($this->routes as $route) {
            $routePattern = preg_replace('/{[^}]+}/', '([^/]+)', $route['path']);
            if ($route['method'] === $method && preg_match("#^$routePattern$#", $parsedUrl['path'], $matches)) {
                $controllerClass = $route['controller'];
                $methodName = $route['methodName'];

                $controller = $this->container->get($controllerClass);
                $reflectionMethod = new ReflectionMethod($controllerClass, $methodName);

                if ($reflectionMethod->isPublic()) {
                    return $reflectionMethod->invoke($controller, $matches[1] ?? null);
                } else {
                    throw new \Exception("Method $methodName is not public.");
                }
            }
        }

        http_response_code(404);
        return '404 Not Found';
    }

    public static function get(Container $container): string
    {
        // I'm not dealing with OPTIONS
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization');
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(204);
            exit();
        }

        $router = new self($container);
        $router->registerRoute($container->getControllers());
        return $router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
    }
}
