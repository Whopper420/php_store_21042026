<?php
class Order
{
    public static function all(string $status = ''): array
    {
        $where = '';
        if ($status) {
            $s     = DB::$pdo->real_escape_string($status);
            $where = "WHERE o.status = '$s'";
        }
        $result = DB::query("
            SELECT o.*, CONCAT(c.first_name, ' ', c.last_name) AS customer_name
            FROM orders o
            LEFT JOIN customers c ON c.id = o.customer_id
            $where
            ORDER BY o.order_date DESC
        ");
        $rows = [];
        while ($row = $result->fetch_assoc()) $rows[] = $row;
        return $rows;
    }

    public static function count(): int
    {
        return (int)DB::query("SELECT COUNT(*) AS n FROM orders")->fetch_assoc()['n'];
    }

    public static function statuses(): array
    {
        $result = DB::query("SELECT DISTINCT status FROM orders WHERE status IS NOT NULL ORDER BY status");
        $rows = [];
        while ($row = $result->fetch_assoc()) $rows[] = $row['status'];
        return $rows;
    }
}