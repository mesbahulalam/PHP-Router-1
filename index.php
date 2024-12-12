<?php
require_once('Router.php');

// Create a new Router instance
$router = new Router();

// Define a route with dynamic segments
$router->addRoute('GET', '/user/{id}', function ($id) {
    echo "User ID: " . $id;
});

// Define a route with regex pattern for matching numbers
$router->addRoute('GET', '/post/{id:\d+}', function ($id) {
    echo "Post ID: " . $id;
});

// Define a route with a regex pattern for an email address
$router->addRoute('GET', '/profile/{email:[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}}', function ($email) {
    echo "Profile Email: " . $email;
});

// Dispatch the current request
$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

$router->dispatch($method, $uri);
