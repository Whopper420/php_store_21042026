<?php if ($withOrders): ?>

<ul class="orders-list">
    <?php foreach ($customers as $c): ?>
    <li class="orders-customer">
        <strong><?= htmlspecialchars($c['first_name'] . ' ' . $c['last_name']) ?></strong>
        <span class="email"><?= htmlspecialchars($c['email']) ?></span>
        <?php if (!empty($c['orders'])): ?>
        <ul class="orders-items">
            <?php foreach ($c['orders'] as $o): ?>
            <li>
                <span class="order-id">#<?= (int)$o['id'] ?></span>
                <span class="badge"><?= htmlspecialchars($o['status'] ?? 'unknown') ?></span>
                <span><?= htmlspecialchars($o['order_date'] ?? '') ?></span>
                <span><?= htmlspecialchars($o['delivery_date'] ?? '') ?></span>
                <?php if ($o['comment']): ?>
                    <span style="opacity:0.6;font-size:12px"><?= htmlspecialchars($o['comment']) ?></span>
                <?php endif; ?>
            </li>
            <?php endforeach; ?>
        </ul>
        <?php else: ?>
            <ul><li><em>No orders</em></li></ul>
        <?php endif; ?>
    </li>
    <?php endforeach; ?>
</ul>

<?php else: ?>
    <?php /* ... your existing card grid code ... */ ?>
<?php endif; ?>