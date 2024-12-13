<?php
require 'Router.php';
$router = new Router();

$router->get('/users', function () {
    echo 'Users List';
});

$router->post('/user/(\d+)', function ($id) {
    echo 'Modified User with ID: ' . $id;
});

$router->get('/users(/([a-zA-Z0-9-_\S]+))?', function ($id = null) {
    if ($id) {
        echo 'User with ID: ' . $id;
    } else {
        echo 'Users List';
    }
});

$router->get('/search/{query}', function ($query) {
    echo 'Search results for: ' . $query;
});

$router->get('/search(/([a-zA-Z0-9-_]+))?', function ($query = null) {
    if ($query) {
        echo 'Search results for: ' . $query;
    } else {
        echo 'Search';
    }
});

$router->get(
    '/blog(/\d+(/\d+(/\d+(/\w+)?)?)?)?',
    function($year = null, $month = null, $day = null, $slug = null) {
        if (!$year) { echo 'Blog overview'; return; }
        if (!$month) { echo 'Blog year overview'; return; }
        if (!$day) { echo 'Blog month overview'; return; }
        if (!$slug) { echo 'Blog day overview'; return; }
        echo 'Blogpost ' . htmlentities($slug) . ' detail';
    }
);

$router->run();