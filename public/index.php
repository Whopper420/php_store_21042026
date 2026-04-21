<?php

require __DIR__ . '/../db/connect.php';
require __DIR__ . '/../src/controllers/CustomerController.php';

$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ($requestUri === '/customers') {

    CustomerController::index($pdo);

} else {
    echo "<h1>Veikals</h1>";
}