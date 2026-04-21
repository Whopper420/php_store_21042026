<?php
function layout($title, $content)
{
?>
<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title) ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        body {
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Arial;
            background: linear-gradient(135deg, #0f172a, #1e293b);
            color: #e2e8f0;
        }

        header {
            padding: 20px;
            text-align: center;
            background: rgba(0,0,0,0.2);
            backdrop-filter: blur(10px);
        }

        header h1 {
            margin: 0;
            font-size: 28px;
            letter-spacing: 1px;
        }

        .container {
            max-width: 1000px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
        }

        .card {
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 16px;
            padding: 20px;
            transition: transform 0.2s ease, background 0.2s ease;
            box-shadow: 0 10px 25px rgba(0,0,0,0.3);
        }

        .card:hover {
            transform: translateY(-5px);
            background: rgba(255,255,255,0.1);
        }

        .name {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .email {
            font-size: 14px;
            opacity: 0.8;
        }

        .badge {
            display: inline-block;
            margin-top: 10px;
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 12px;
            background: #38bdf8;
            color: #0f172a;
        }

        footer {
            text-align: center;
            padding: 30px;
            opacity: 0.5;
            font-size: 12px;
        }
    </style>
</head>
<body>

<header>
    <h1><?= htmlspecialchars($title) ?></h1>
</header>

<div class="container">
    <?= $content ?>
</div>

<footer>
    i just hit the jackpot!!!
</footer>

</body>
</html>
<?php
}