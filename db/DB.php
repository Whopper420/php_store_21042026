<?php

class DB
{
    public static $pdo;

    public static function connect(): void
    {
        $cfg = require __DIR__ . '/../config.php';
        self::$pdo = new mysqli($cfg['db_host'], $cfg['db_user'], $cfg['db_pass'], $cfg['db_name']);
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