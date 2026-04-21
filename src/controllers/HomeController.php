<?php
class HomeController
{
    public static function index(): void
    {
        $totalCustomers = Customer::count();
        $totalOrders    = Order::count();

        ob_start();
        require __DIR__ . '/../../views/home.php';
        $content = ob_get_clean();

        layout('Veikals', $content);
    }
}
