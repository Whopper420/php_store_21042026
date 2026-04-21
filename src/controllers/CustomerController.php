<?php

require_once __DIR__ . '/../../db/DB.php';

class CustomerController
{
    public static function index($pdo)
    {
        $result = DB::query("SELECT * FROM customers");

        echo "<h1>Klienti</h1>";

        while ($c = $result->fetch_assoc()) {
            echo "<p>{$c['first_name']} {$c['last_name']} ({$c['email']})</p>";
        }
    }
}