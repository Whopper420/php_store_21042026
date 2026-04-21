<?php

require __DIR__ . '/../db/DB.php';
require __DIR__ . '/../src/controllers/CustomerController.php';

DB::connect();

$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

switch ($requestUri) {
    case '/customers':
        CustomerController::index();
        break;

    default:
        echo "<h1>Veikals</h1>";
}