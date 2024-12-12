<?php

class Router
{
    private $routes = [];

    // Register a new route with an optional regex pattern
    public function addRoute($method, $pattern, $callback)
    {
        $this->routes[] = [
            'method' => strtoupper($method),
            'pattern' => $pattern,
            'callback' => $callback
        ];
    }

    // Match the incoming request to the registered routes
    public function dispatch($method, $uri)
    {
        $method = strtoupper($method); // Normalize HTTP method (GET, POST, etc.)
        foreach ($this->routes as $route) {
            if ($route['method'] === $method) {
                if (preg_match($this->createPattern($route['pattern']), $uri, $matches)) {
                    array_shift($matches); // Remove the full match (it's always at index 0)
                    return call_user_func_array($route['callback'], $matches);
                }
            }
        }
        // If no route matches, return 404 response
        http_response_code(404);
        echo "404 Not Found";
    }

    // Converts dynamic parameters in routes to regex patterns
    private function createPattern($pattern)
    {
        // Replace placeholders like {id} with regex patterns
        return '/^' . preg_replace_callback('/{([a-zA-Z0-9_]+)}/', function ($matches) {
            return '(?P<' . $matches[1] . '>[^/]+)';
        }, $pattern) . '$/';
    }
}

