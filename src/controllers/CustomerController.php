<?php

class CustomerController
{
    public static function index($pdo)
    {
        $result = query("SELECT * FROM customers");

        echo "<h1>Klienti</h1>";

        while ($c = $result->fetch_assoc()) {
            echo "<p>{$c['first_name']} {$c['last_name']} ({$c['email']})</p>";
        }
    }
}


