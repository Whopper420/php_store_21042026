<?php

require __DIR__ . '/../db/connect.php';

$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ($requestUri === '/customers') {

    $result = $pdo->query("SELECT * FROM customers");

    echo "<h1>Klienti</h1>";

    while ($c = $result->fetch_assoc()) {
        echo "<p>{$c['first_name']} {$c['last_name']} ({$c['email']})</p>";
    }

} else {
    echo "<h1>Veikals</h1>";
}
























