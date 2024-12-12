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
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];
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

    // Shorthand method for GET requests
    public function get($pattern, $callback)
    {
        $this->addRoute('GET', $pattern, $callback);
    }

    // Shorthand method for POST requests
    public function post($pattern, $callback)
    {
        $this->addRoute('POST', $pattern, $callback);
    }

    // Shorthand method for both GET and POST requests
    public function both($pattern, $callback)
    {
        $this->addRoute('GET', $pattern, $callback);
        $this->addRoute('POST', $pattern, $callback);
    }
}

