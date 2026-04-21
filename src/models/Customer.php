<?php
require_once __DIR__ . '/../../db/DB.php';

class Customer
{
    public static function paginated(string $search, string $sort, int $page, int $perPage): array
    {
        $pdo    = DB::$pdo;
        $offset = ($page - 1) * $perPage;
        $like   = '%' . $pdo->real_escape_string($search) . '%';
        $where  = $search
            ? "WHERE CONCAT(first_name,' ',last_name) LIKE '$like' OR email LIKE '$like'"
            : '';

        $result = DB::query("SELECT * FROM customers $where ORDER BY $sort ASC LIMIT $offset, $perPage");
        $rows = [];
        while ($row = $result->fetch_assoc()) $rows[] = $row;
        return $rows;
    }

    public static function count(string $search): int
    {
        $pdo   = DB::$pdo;
        $like  = '%' . $pdo->real_escape_string($search) . '%';
        $where = $search
            ? "WHERE CONCAT(first_name,' ',last_name) LIKE '$like' OR email LIKE '$like'"
            : '';
        return (int)DB::query("SELECT COUNT(*) AS n FROM customers $where")->fetch_assoc()['n'];
    }

    public static function allWithOrders(string $search, string $sort): array
{
    $pdo   = DB::$pdo;
    $like  = '%' . $pdo->real_escape_string($search) . '%';
    $where = $search
        ? "WHERE CONCAT(c.first_name,' ',c.last_name) LIKE '$like' OR c.email LIKE '$like'"
        : '';

    $result = DB::query("
        SELECT c.id, c.first_name, c.last_name, c.email,
               o.id AS order_id, o.status, o.comment, o.order_date, o.delivery_date
        FROM customers c
        LEFT JOIN orders o ON o.customer_id = c.id
        $where
        ORDER BY c.$sort ASC, o.order_date DESC
    ");

    $map = [];
    while ($row = $result->fetch_assoc()) {
        $cid = $row['id'];
        if (!isset($map[$cid])) {
            $map[$cid] = [
                'id'         => $cid,
                'first_name' => $row['first_name'],
                'last_name'  => $row['last_name'],
                'email'      => $row['email'],
                'orders'     => [],
            ];
        }
        if ($row['order_id']) {
            $map[$cid]['orders'][] = [
                'id'            => $row['order_id'],
                'status'        => $row['status'],
                'comment'       => $row['comment'],
                'order_date'    => $row['order_date'],
                'delivery_date' => $row['delivery_date'],
            ];
        }
    }
    return array_values($map);
}

    public static function add(string $firstName, string $lastName, string $email): bool
    {
        $stmt = DB::$pdo->prepare("INSERT INTO customers (first_name, last_name, email) VALUES (?, ?, ?)");
        $stmt->bind_param('sss', $firstName, $lastName, $email);
        return $stmt->execute();
    }

    public static function delete(int $id): bool
    {
        $stmt = DB::$pdo->prepare("DELETE FROM customers WHERE id = ?");
        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }

    public static function hasOrders(int $id): bool
    {
        $stmt = DB::$pdo->prepare("SELECT COUNT(*) AS n FROM orders WHERE customer_id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        return (int)$stmt->get_result()->fetch_assoc()['n'] > 0;
    }
}