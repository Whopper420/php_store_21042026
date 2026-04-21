<?php
function layout($title, $content, $flash = null)
{
?>
<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title) ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        *, *::before, *::after { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Arial;
            background: linear-gradient(135deg, #0f172a, #1e293b);
            color: #e2e8f0;
            min-height: 100vh;
        }
        header {
            padding: 20px 40px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: rgba(0,0,0,0.2);
            backdrop-filter: blur(10px);
            position: sticky;
            top: 0;
            z-index: 10;
        }
        header h1 { margin: 0; font-size: 22px; letter-spacing: 1px; }
        nav a {
            color: #94a3b8;
            text-decoration: none;
            margin-left: 20px;
            font-size: 14px;
            transition: color 0.2s;
        }
        nav a:hover { color: #e2e8f0; }
        .container { max-width: 1100px; margin: 40px auto; padding: 0 20px; }


        .flash {
            padding: 12px 18px;
            border-radius: 10px;
            margin-bottom: 24px;
            font-size: 14px;
        }
        .flash.success { background: rgba(56,189,248,0.15); border: 1px solid #38bdf8; color: #7dd3fc; }
        .flash.error   { background: rgba(248,113,113,0.15); border: 1px solid #f87171; color: #fca5a5; }


        .stats { display: flex; gap: 16px; margin-bottom: 28px; flex-wrap: wrap; }
        .stat-card {
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 12px;
            padding: 14px 22px;
            min-width: 140px;
        }
        .stat-card .label { font-size: 12px; opacity: 0.6; margin-bottom: 4px; }
        .stat-card .value { font-size: 26px; font-weight: 700; color: #38bdf8; }

        .controls {
            display: flex;
            gap: 12px;
            margin-bottom: 28px;
            flex-wrap: wrap;
            align-items: center;
        }
        .controls input, .controls select {
            background: rgba(255,255,255,0.07);
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 8px;
            color: #e2e8f0;
            padding: 8px 14px;
            font-size: 14px;
            outline: none;
            transition: border-color 0.2s;
        }
        .controls input:focus, .controls select:focus {
            border-color: #38bdf8;
        }
        .controls input { flex: 1; min-width: 200px; }
        .controls select option { background: #1e293b; }

        .add-form {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 36px;
        }
        .add-form h2 { margin: 0 0 18px; font-size: 16px; opacity: 0.8; }
        .form-row { display: flex; gap: 12px; flex-wrap: wrap; }
        .form-row input {
            flex: 1;
            min-width: 160px;
            background: rgba(255,255,255,0.07);
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 8px;
            color: #e2e8f0;
            padding: 9px 14px;
            font-size: 14px;
            outline: none;
            transition: border-color 0.2s;
        }
        .form-row input:focus { border-color: #38bdf8; }
        .form-row input::placeholder { color: #64748b; }
        .btn-primary {
            background: #38bdf8;
            color: #0f172a;
            border: none;
            border-radius: 8px;
            padding: 9px 20px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }
        .btn-primary:hover { background: #7dd3fc; }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 20px;
        }
        .card {
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 16px;
            padding: 20px;
            transition: transform 0.2s ease, background 0.2s ease;
            box-shadow: 0 10px 25px rgba(0,0,0,0.3);
            position: relative;
        }
        .card:hover { transform: translateY(-4px); background: rgba(255,255,255,0.1); }
        .avatar {
            width: 42px; height: 42px;
            border-radius: 50%;
            background: #0369a1;
            display: flex; align-items: center; justify-content: center;
            font-size: 15px; font-weight: 700; color: #bae6fd;
            margin-bottom: 12px;
        }
        .name { font-size: 16px; font-weight: 600; margin-bottom: 6px; }
        .email { font-size: 13px; opacity: 0.7; margin-bottom: 10px; word-break: break-all; }
        .card-footer { display: flex; align-items: center; justify-content: space-between; margin-top: 12px; }
        .badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 999px;
            font-size: 11px;
            background: #38bdf8;
            color: #0f172a;
            font-weight: 600;
        }
        .btn-delete {
            background: rgba(248,113,113,0.15);
            border: 1px solid rgba(248,113,113,0.3);
            color: #fca5a5;
            border-radius: 7px;
            padding: 4px 10px;
            font-size: 12px;
            cursor: pointer;
            text-decoration: none;
            transition: background 0.2s;
        }
        .btn-delete:hover { background: rgba(248,113,113,0.3); }

        .pagination { display: flex; gap: 8px; margin-top: 36px; justify-content: center; flex-wrap: wrap; }
        .pagination a, .pagination span {
            padding: 7px 14px;
            border-radius: 8px;
            font-size: 13px;
            text-decoration: none;
        }
        .pagination a {
            background: rgba(255,255,255,0.07);
            border: 1px solid rgba(255,255,255,0.1);
            color: #e2e8f0;
            transition: background 0.2s;
        }
        .pagination a:hover { background: rgba(255,255,255,0.15); }
        .pagination .current {
            background: #38bdf8;
            color: #0f172a;
            font-weight: 600;
        }
        .empty { text-align: center; opacity: 0.5; padding: 60px 0; font-size: 15px; }
        footer { text-align: center; padding: 30px; opacity: 0.4; font-size: 12px; }
    </style>
</head>
<body>
<header>
    <h1>🧍‍♂️ Veikals</h1>
    <nav>
        <a href="/customers">Klienti</a>
    </nav>
</header>
<div class="container">
    <?php if ($flash): ?>
        <div class="flash <?= htmlspecialchars($flash['type']) ?>">
            <?= htmlspecialchars($flash['msg']) ?>
        </div>
    <?php endif; ?>
    <?= $content ?>
</div>
<footer>i just hit the jackpot!!!</footer>
</body>
</html>
<?php
}