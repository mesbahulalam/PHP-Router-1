<?php
require_once 'Router.php';
// Usage example
$router = new Router();
$router->get('/', function () {
    echo 'Home';
});
$router->post('/user/{id}', function ($id) {
    echo 'User ' . $id;
});
$router->get('/user/{id}/{name}', function ($id, $name) {
    echo 'User ' . $id . ' ' . $name;
});
$router->run();