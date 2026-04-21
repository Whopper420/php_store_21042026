<?php
require_once __DIR__ . '/../../db/DB.php';
require_once __DIR__ . '/../models/Order.php';
require_once __DIR__ . '/../../views/layout.php';

class OrderController
{
    private static int $perPage = 9;

    public static function index(): void
    {
        $flash  = self::getFlash();
        $search = trim($_GET['q'] ?? '');
        $sort   = in_array($_GET['sort'] ?? '', ['o.order_date', 'o.status', 'c.first_name'])
            ? $_GET['sort'] : 'o.order_date';
        $page   = max(1, (int)($_GET['page'] ?? 1));
        $total  = Order::count($search);
        $pages  = max(1, (int)ceil($total / self::$perPage));
        $page   = min($page, $pages);
        $orders = Order::paginated($search, $sort, $page, self::$perPage);

        ob_start();
        require __DIR__ . '/../../views/orders.php';
        $content = ob_get_clean();

        layout('Pasūtījumi', $content, $flash);
    }

    private static function setFlash(string $type, string $msg): void
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $_SESSION['flash'] = compact('type', 'msg');
    }

    private static function getFlash(): ?array
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $flash = $_SESSION['flash'] ?? null;
        unset($_SESSION['flash']);
        return $flash;
    }
}