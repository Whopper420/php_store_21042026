<?php
function layout(string $title, string $content, ?array $flash = null): void
{ ?>
<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title) ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body { font-family: sans-serif; max-width: 960px; margin: 0 auto; padding: 20px; }
        nav { margin-bottom: 24px; }
        nav a { margin-right: 16px; text-decoration: none; color: #333; font-weight: bold; }
        nav a:hover { text-decoration: underline; }
        .flash-success { color: green; }
        .flash-error { color: red; }
        table { width: 100%; border-collapse: collapse; margin-top: 12px; }
        th, td { padding: 8px 10px; border-bottom: 1px solid #ddd; text-align: left; }
        th { background: #f5f5f5; }
        input, select { padding: 6px 10px; margin-right: 6px; }
        button { padding: 6px 14px; cursor: pointer; }
        footer { margin-top: 40px; color: #aaa; font-size: 12px; }
    </style>
</head>
<body>
<nav>
    <a href="/">Home</a>
    <a href="/customers">Klienti</a>
    <a href="/orders">Pasūtījumi</a>
</nav>
<h1><?= htmlspecialchars($title) ?></h1>
<?php if ($flash): ?>
    <p class="flash-<?= htmlspecialchars($flash['type']) ?>"><?= htmlspecialchars($flash['msg']) ?></p>
<?php endif; ?>
<?= $content ?>
<footer><a href="https://youtu.be/dQw4w9WgXcQ">i just hit the jackpot!!!</a></footer>
</body>
</html>
<?php }