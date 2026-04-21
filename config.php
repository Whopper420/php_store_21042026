<?php
function loadEnv(string $path): void
{
    if (!file_exists($path)) return;
    foreach (file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        if (str_starts_with(trim($line), '#') || !str_contains($line, '=')) continue;
        [$key, $value] = explode('=', $line, 2);
        $_ENV[trim($key)] = trim($value);
    }
}

loadEnv(__DIR__ . '/.env');

return [
    'db_host' => $_ENV['DB_HOST'] ?? '127.0.0.1',
    'db_user' => $_ENV['DB_USER'] ?? '',
    'db_pass' => $_ENV['DB_PASS'] ?? '',
    'db_name' => $_ENV['DB_NAME'] ?? '',
];