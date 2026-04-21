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

        self::$pdo = new mysqli($servername, $username, $password, $dbname);

        if (self::$pdo->connect_error) {
            die("Connection failed: " . self::$pdo->connect_error);
        }

        self::$pdo->set_charset("utf8mb4");
    }

    public static function query($sql)
    {
        $result = self::$pdo->query($sql);

        if (!$result) {
            die("SQL error: " . self::$pdo->error);
        }

        return $result;
    }
}