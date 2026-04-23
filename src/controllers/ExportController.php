<?php
class ExportController
{
    public static function customers(): void
    {
        $rows = Customer::allRaw();
        self::sendCsv('customers', ['id', 'first_name', 'last_name', 'email', 'birth_date', 'points'], $rows);
    }

    public static function orders(): void
    {
        $rows = Order::allRaw();
        self::sendCsv('orders', ['id', 'customer_name', 'order_date', 'delivery_date', 'status', 'comment'], $rows);
    }

    private static function sendCsv(string $name, array $headers, array $rows): void
    {
        header('Content-Type: text/csv');
        header("Content-Disposition: attachment; filename=\"$name.csv\"");

        $out = fopen('php://output', 'w');
        fputcsv($out, $headers);
        foreach ($rows as $row) {
            fputcsv($out, array_map(fn($h) => $row[$h] ?? '', $headers));
        }
        fclose($out);
        exit;
    }
}