<?php

require_once __DIR__ . '/../../db/DB.php';

class CustomerController
{
    public static function index()
    {
        $result = DB::query("SELECT * FROM customers");

        echo "<h1>Klienti</h1>";

        while ($c = $result->fetch_assoc()) {
            $first = htmlspecialchars($c['first_name']);
            $last  = htmlspecialchars($c['last_name']);
            $email = htmlspecialchars($c['email']);

            echo "<p>{$first} {$last} ({$email})</p>";
        }
    }
}