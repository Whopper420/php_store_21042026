<?php

require_once __DIR__ . '/../../db/DB.php';
require_once __DIR__ . '/../../views/layout.php';

class CustomerController
{
    public static function index()
    {
        $result = DB::query("SELECT * FROM customers");

        ob_start();
        ?>

        <div class="grid">
            <?php while ($c = $result->fetch_assoc()): ?>
                <div class="card">
                    <div class="name">
                        <?= htmlspecialchars($c['first_name'] . ' ' . $c['last_name']) ?>
                    </div>

                    <div class="email">
                        <?= htmlspecialchars($c['email']) ?>
                    </div>

                    <div class="badge">Customer</div>
                </div>
            <?php endwhile; ?>
        </div>

        <?php
        $content = ob_get_clean();

        layout("Klienti", $content);
    }
}