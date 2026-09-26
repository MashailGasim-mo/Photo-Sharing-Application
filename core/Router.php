<?php

class Router
{
    private array $routes = [];

    public function get(string $pattern, callable|array $handler): void
    {
        $this->addRoute('GET', $pattern, $handler);
    }

    public function post(string $pattern, callable|array $handler): void
    {
        $this->addRoute('POST', $pattern, $handler);
    }

    private function addRoute(
        string $method,
        string $pattern,
        callable|array $handler
    ): void {
        $this->routes[] = [
            'method' => $method,
            'pattern' => $pattern,
            'handler' => $handler
        ];
    }

    public function dispatch(string $uri, string $method): void
    {
        $uri = parse_url($uri, PHP_URL_PATH);

        foreach ($this->routes as $route) {
            if ($route['method'] !== $method) {
                continue;
            }

            $pattern = $this->convertPatternToRegex($route['pattern']);

            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches);

                $this->executeHandler(
                    $route['handler'],
                    $matches
                );

                return;
            }
        }

        http_response_code(404);
        echo '404 - Page Not Found';
    }

    private function convertPatternToRegex(string $pattern): string
    {
        $pattern = preg_replace(
            '/\{([a-zA-Z_][a-zA-Z0-9_]*)\}/',
            '([^/]+)',
            $pattern
        );

        return '#^' . $pattern . '/?$#';
    }

    private function executeHandler(
        callable|array $handler,
        array $parameters
    ): void {
        if (is_array($handler)) {
            [$controller, $method] = $handler;

            $controllerInstance = new $controller();

            call_user_func_array(
                [$controllerInstance, $method],
                $parameters
            );

            return;
        }

        call_user_func_array($handler, $parameters);
    }
}