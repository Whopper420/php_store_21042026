<?php

class DB
{
    public static $pdo;

    public static function connect()
    {
        $servername = "172.30.224.1";
        $username = "store_app";
        $password = "password";
        $dbname = "store_dev";

        $pdo = new mysqli($servername, $username, $password, $dbname);

        if ($pdo->connect_error) {
        die("Connection failed: " . $pdo->connect_error);
}
    }

    public static function query($sql)
    {
        $stmt = self::$pdo->query($sql);
        return $stmt->fetchAll();
    }
}