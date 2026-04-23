<table>
    <thead>
        <tr><th>Stat</th><th>Value</th></tr>
    </thead>
    <tbody>
        <tr><td>Total customers</td><td><?= (int)$totalCustomers ?></td></tr>
        <tr><td>Total orders</td><td><?= (int)$totalOrders ?></td></tr>
        <?php foreach ($ordersByStatus as $status => $count): ?>
        <tr><td>Orders — <?= htmlspecialchars($status) ?></td><td><?= (int)$count ?></td></tr>
        <?php endforeach; ?>
        <tr><td>Customers with no orders</td><td><?= (int)$customersNoOrders ?></td></tr>
        <tr><td>Customers with orders</td><td><?= (int)$customersWithOrders ?></td></tr>
        <tr><td>Most recent order</td><td><?= htmlspecialchars($latestOrder ?? '—') ?></td></tr>
    </tbody>
</table>