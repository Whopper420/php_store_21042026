<?php
class CustomerController
{
    public static function index(): void
    {
        $flash      = self::getFlash();
        $search     = trim($_GET['q'] ?? '');
        $withOrders = ($_GET['with-orders'] ?? '') === 'full';
        $customers  = $withOrders ? Customer::allWithOrders($search) : Customer::all($search);

        ob_start();
        require __DIR__ . '/../../views/customers.php';
        $content = ob_get_clean();

        layout('Klienti', $content, $flash);
    }

    public static function add(): void
    {
        $first     = trim($_POST['first_name'] ?? '');
        $last      = trim($_POST['last_name']  ?? '');
        $email     = trim($_POST['email']      ?? '');
        $birthDate = trim($_POST['birth_date'] ?? '');
        $points    = (int)($_POST['points']    ?? 0);

        if (!$first || !$last || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            self::setFlash('error', 'Invalid data.');
        } elseif (Customer::add($first, $last, $email, $birthDate, $points)) {
            self::setFlash('success', "Customer $first $last added!");
        } else {
            self::setFlash('error', 'Could not add customer.');
        }

        header('Location: /customers');
        exit;
    }

    public static function delete(): void
    {
        $id = (int)($_GET['id'] ?? 0);
        if ($id > 0) {
            if (Customer::hasOrders($id)) {
                self::setFlash('error', 'Cannot delete — customer has orders.');
            } else {
                Customer::delete($id);
                self::setFlash('success', 'Customer deleted.');
            }
        }
        header('Location: /customers');
        exit;
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