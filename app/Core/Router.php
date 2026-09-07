<?php

declare(strict_types=1);

class Router
{
    /** @var array<int, array{method: string, pattern: string, handler: string}> */
    private array $routes = [];

    public function add(string $method, string $pattern, string $handler): void
    {
        $this->routes[] = compact('method', 'pattern', 'handler');
    }

    public function dispatch(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = rtrim((string) parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
        $uri = $uri === '' ? '/' : $uri;

        foreach ($this->routes as $route) {
            if ($route['method'] !== $method) {
                continue;
            }

            $pattern = preg_replace('#\{[a-zA-Z_]+}#', '([0-9]+)', $route['pattern']);
            $pattern = '#^' . $pattern . '$#';

            if (preg_match($pattern, $uri, $matches)) {
                [$controllerName, $action] = explode('@', $route['handler']);
                array_shift($matches);
                $controller = $this->loadController($controllerName);
                $controller->$action(...array_map('intval', $matches));
                return;
            }
        }

        http_response_code(404);
        $this->loadController('DashboardController')->view('errors/404', ['title' => '404']);
    }

    private function loadController(string $controllerName): object
    {
        require_once __DIR__ . "/../Controllers/{$controllerName}.php";
        return new $controllerName();
    }
}