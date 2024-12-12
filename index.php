<?php
require_once('Router.php');

// Create a new Router instance
$router = new Router();

// Define a route that responds to GET requests
$router->get('/user/{id}', function ($id) {
    echo "User ID (GET): " . $id;
});

// Define a route that responds to POST requests
$router->post('/user/{id}', function ($id) {
    echo "User ID (POST): " . $id;
});

// Define a route that responds to both GET and POST requests
$router->both('/submit', function () {
    echo "Form Submitted!";
});

$router->dispatch();
