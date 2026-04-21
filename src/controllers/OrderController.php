<?php
class OrderController
{
    public static function index(): void
    {
        $status   = trim($_GET['status'] ?? '');
        $orders   = Order::all($status);
        $statuses = Order::statuses();

        ob_start();
        require __DIR__ . '/../../views/orders.php';
        $content = ob_get_clean();

        layout('Pasūtījumi', $content);
    }

    public static function create(): void
    {
        $customers = Customer::all();

        ob_start();
        require __DIR__ . '/../../views/orders_create.php';
        $content = ob_get_clean();

        layout('Jauns pasūtījums', $content);
    }

    public static function store(): void
    {
        $customerId   = (int)($_POST['customer_id']   ?? 0);
        $orderDate    = trim($_POST['order_date']    ?? '');
        $deliveryDate = trim($_POST['delivery_date'] ?? '');
        $status       = trim($_POST['status']        ?? '');
        $comment      = trim($_POST['comment']       ?? '');

        if (!$customerId || !$orderDate) {
            header('Location: /orders/create');
            exit;
        }

        Order::create($customerId, $orderDate, $deliveryDate, $status, $comment);
        header('Location: /orders');
        exit;
    }
}