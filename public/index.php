<?php
session_start();
require __DIR__ . '/../db/DB.php';
require __DIR__ . '/../src/models/Customer.php';
require __DIR__ . '/../src/models/Order.php';
require __DIR__ . '/../src/controllers/HomeController.php';
require __DIR__ . '/../src/controllers/CustomerController.php';
require __DIR__ . '/../src/controllers/OrderController.php';
require __DIR__ . '/../views/layout.php';

DB::connect();

$uri    = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

match (true) {
    $uri === '/'                                       => HomeController::index(),
    $uri === '/customers' && $method === 'GET'         => CustomerController::index(),
    $uri === '/customers/add' && $method === 'POST'    => CustomerController::add(),
    $uri === '/customers/delete'                       => CustomerController::delete(),
    $uri === '/orders' && $method === 'GET'            => OrderController::index(),
    $uri === '/orders/create' && $method === 'GET'     => OrderController::create(),
    $uri === '/orders/store' && $method === 'POST'     => OrderController::store(),
    default => (function() {
        echo "<p>404 — page not found</p>";
    })()
};