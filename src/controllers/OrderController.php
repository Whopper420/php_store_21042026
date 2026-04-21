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
}