<?php
session_start();
require __DIR__ . '/../db/DB.php';
require __DIR__ . '/../src/controllers/CustomerController.php';
require __DIR__ . '/../src/controllers/OrderController.php';

DB::connect();

$uri    = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

match (true) {
    $uri === '/customers' && $method === 'GET'      => CustomerController::index(),
    $uri === '/customers/add' && $method === 'POST' => CustomerController::add(),
    $uri === '/customers/delete'                    => CustomerController::delete(),
    $uri === '/orders' && $method === 'GET'         => OrderController::index(),
    default => (function() {
        echo "<h1 style='font-family:sans-serif;padding:40px'>Veikals — <a href='/customers'>Klienti</a> | <a href='/orders'>Pasūtījumi</a></h1>";
    })()
};