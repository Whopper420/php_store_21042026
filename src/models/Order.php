<?php
class Order
{
    public int $id;
    public int $customer_id;
    public ?string $status;
    public ?string $order_date;
    public ?string $delivery_date;
    public ?string $comment;
    public ?string $customer_name;

    public function __construct(array $row)
    {
        $this->id            = (int)$row['id'];
        $this->customer_id   = (int)($row['customer_id'] ?? 0);
        $this->status        = $row['status']        ?? null;
        $this->order_date    = $row['order_date']    ?? null;
        $this->delivery_date = $row['delivery_date'] ?? null;
        $this->comment       = $row['comment']       ?? null;
        $this->customer_name = $row['customer_name'] ?? null;
    }

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
        while ($row = $result->fetch_assoc()) $rows[] = new self($row);
        return $rows;
    }

    public static function count(): int
    {
        return (int)DB::query("SELECT COUNT(*) AS n FROM orders")->fetch_assoc()['n'];
    }

    public static function statuses(): array
    {
        $result = DB::query("SELECT DISTINCT status FROM orders WHERE status IS NOT NULL ORDER BY status");
        $rows   = [];
        while ($row = $result->fetch_assoc()) $rows[] = $row['status'];
        return $rows;
    }

    public static function create(int $customerId, string $orderDate, string $deliveryDate, string $status, string $comment): bool
    {
        $stmt = DB::$pdo->prepare("
            INSERT INTO orders (customer_id, order_date, delivery_date, status, comment)
            VALUES (?, ?, ?, ?, ?)
        ");
        $stmt->bind_param('issss', $customerId, $orderDate, $deliveryDate, $status, $comment);
        return $stmt->execute();
    }
    public static function allRaw(): array
    {
        $result = DB::query("
            SELECT o.id, o.order_date, o.delivery_date, o.status, o.comment,
                CONCAT(c.first_name, ' ', c.last_name) AS customer_name
            FROM orders o
            LEFT JOIN customers c ON c.id = o.customer_id
            ORDER BY o.order_date DESC
        ");
        $rows = [];
        while ($row = $result->fetch_assoc()) $rows[] = $row;
        return $rows;
    }
}