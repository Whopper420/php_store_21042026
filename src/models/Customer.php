<?php
class Customer
{
    public int $id;
    public string $first_name;
    public string $last_name;
    public string $email;
    public array $orders = [];

    public function __construct(array $row)
    {
        $this->id         = (int)$row['id'];
        $this->first_name = $row['first_name'];
        $this->last_name  = $row['last_name'];
        $this->email      = $row['email'];
    }

    public function fullName(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public static function all(string $search = ''): array
    {
        $like   = '%' . DB::$pdo->real_escape_string($search) . '%';
        $where  = $search ? "WHERE CONCAT(first_name,' ',last_name) LIKE '$like' OR email LIKE '$like'" : '';
        $result = DB::query("SELECT * FROM customers $where ORDER BY first_name ASC");
        $rows   = [];
        while ($row = $result->fetch_assoc()) $rows[] = new self($row);
        return $rows;
    }

    public static function allWithOrders(string $search = ''): array
    {
        $like   = '%' . DB::$pdo->real_escape_string($search) . '%';
        $where  = $search ? "WHERE CONCAT(c.first_name,' ',c.last_name) LIKE '$like' OR c.email LIKE '$like'" : '';
        $result = DB::query("
            SELECT c.id, c.first_name, c.last_name, c.email,
                   o.id AS order_id, o.status, o.order_date, o.delivery_date, o.comment
            FROM customers c
            LEFT JOIN orders o ON o.customer_id = c.id
            $where
            ORDER BY c.first_name ASC, o.order_date DESC
        ");
        $map = [];
        while ($row = $result->fetch_assoc()) {
            $cid = (int)$row['id'];
            if (!isset($map[$cid])) {
                $map[$cid] = new self($row);
            }
            if ($row['order_id']) {
                $map[$cid]->orders[] = new Order([
                    'id'            => $row['order_id'],
                    'customer_id'   => $cid,
                    'status'        => $row['status'],
                    'order_date'    => $row['order_date'],
                    'delivery_date' => $row['delivery_date'],
                    'comment'       => $row['comment'],
                ]);
            }
        }
        return array_values($map);
    }

    public static function count(): int
    {
        return (int)DB::query("SELECT COUNT(*) AS n FROM customers")->fetch_assoc()['n'];
    }

    public static function add(string $first, string $last, string $email): bool
    {
        $stmt = DB::$pdo->prepare("INSERT INTO customers (first_name, last_name, email) VALUES (?, ?, ?)");
        $stmt->bind_param('sss', $first, $last, $email);
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