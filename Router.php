<?php
class Router {
    private $routes = [];

    public function addRoute($method, $pattern, $callback) {
        $this->routes[] = [
            'method' => $method,
            'pattern' => $pattern,
            'callback' => $callback,
        ];
    }

    public function get($pattern, $callback) {
        $this->addRoute('GET', $pattern, $callback);
    }

    public function post($pattern, $callback) {
        $this->addRoute('POST', $pattern, $callback);
    }

    public function both($pattern, $callback) {
        $this->addRoute('GET', $pattern, $callback);
        $this->addRoute('POST', $pattern, $callback);
    }

    public function run() {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $requestUri = rtrim($requestUri, '/');

        foreach ($this->routes as $route) {
            if ($requestMethod == $route['method']) {
                // $pattern = preg_replace('/\{(\w+)\}/', '(\w+)', $route['pattern']);
                // $pattern = preg_replace('/\{(\w+)\}/', '([a-zA-Z0-9-_]+)', $pattern);
                $pattern = preg_replace('/\{(.*?)\}/', '(.*?)', $route['pattern']);
                // $pattern = preg_replace('/\{(\w+)\}/', '([a-zA-Z0-9-_ ]+)', $route['pattern']);
                $pattern = preg_replace('/\(([^)]+)\)\?/', '(?:\1)?', $pattern); // Handle optional segments
                if (preg_match('#^' . $pattern . '$#', $requestUri, $matches)) {
                    array_shift($matches);
                    call_user_func_array($route['callback'], $matches);
                    return;
                }
            }
        }

        echo '404 Not Found';
    }
}
