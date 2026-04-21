<?php
require_once __DIR__ . '/../../db/DB.php';

class Order
{
    public static function paginated(string $search, string $sort, int $page, int $perPage): array
    {
        $pdo    = DB::$pdo;
        $offset = ($page - 1) * $perPage;
        $like   = '%' . $pdo->real_escape_string($search) . '%';
        $where  = $search
            ? "WHERE o.status LIKE '$like' OR o.comment LIKE '$like' OR CONCAT(c.first_name,' ',c.last_name) LIKE '$like'"
            : '';

        $result = DB::query("
            SELECT o.*, CONCAT(c.first_name, ' ', c.last_name) AS customer_name
            FROM orders o
            LEFT JOIN customers c ON c.id = o.customer_id
            $where
            ORDER BY $sort ASC
            LIMIT $offset, $perPage
        ");

        $rows = [];
        while ($row = $result->fetch_assoc()) $rows[] = $row;
        return $rows;
    }

    public static function count(string $search): int
    {
        $pdo   = DB::$pdo;
        $like  = '%' . $pdo->real_escape_string($search) . '%';
        $where = $search
            ? "WHERE o.status LIKE '$like' OR o.comment LIKE '$like' OR CONCAT(c.first_name,' ',c.last_name) LIKE '$like'"
            : '';

        return (int)DB::query("
            SELECT COUNT(*) AS n
            FROM orders o
            LEFT JOIN customers c ON c.id = o.customer_id
            $where
        ")->fetch_assoc()['n'];
    }
}