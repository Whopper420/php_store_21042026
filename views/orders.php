<form method="GET" action="/orders" style="margin-bottom:16px">
    <select name="status" onchange="this.form.submit()">
        <option value="">All statuses</option>
        <?php foreach ($statuses as $s): ?>
            <option value="<?= htmlspecialchars($s) ?>" <?= $status === $s ? 'selected' : '' ?>>
                <?= htmlspecialchars($s) ?>
            </option>
        <?php endforeach; ?>
    </select>
    <button type="submit">Filter</button>
    <?php if ($status): ?>
        <a href="/orders">Clear</a>
    <?php endif; ?>
</form>

<table>
    <thead>
        <tr><th>#</th><th>Customer</th><th>Date</th><th>Delivery</th><th>Status</th><th>Comment</th></tr>
    </thead>
    <tbody>
        <?php foreach ($orders as $o): ?>
        <tr>
            <td><?= (int)$o['id'] ?></td>
            <td><?= htmlspecialchars($o['customer_name'] ?? '—') ?></td>
            <td><?= htmlspecialchars($o['order_date'] ?? '—') ?></td>
            <td><?= htmlspecialchars($o['delivery_date'] ?? '—') ?></td>
            <td><?= htmlspecialchars($o['status'] ?? '—') ?></td>
            <td><?= htmlspecialchars($o['comment'] ?? '') ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>