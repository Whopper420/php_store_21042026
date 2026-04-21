<?php
// Variables: $orders, $total, $pages, $page, $search, $sort
?>

<div class="stats">
    <div class="stat-card">
        <div class="label">Total orders</div>
        <div class="value"><?= (int)$total ?></div>
    </div>
    <div class="stat-card">
        <div class="label">Page</div>
        <div class="value"><?= $page ?> / <?= $pages ?></div>
    </div>
</div>

<form method="GET" action="/orders">
    <div class="controls">
        <input type="text" name="q" value="<?= htmlspecialchars($search) ?>" placeholder="Search by customer, status…">
        <select name="sort" onchange="this.form.submit()">
            <option value="o.order_date"  <?= $sort === 'o.order_date'  ? 'selected' : '' ?>>Sort: date</option>
            <option value="o.status"      <?= $sort === 'o.status'      ? 'selected' : '' ?>>Sort: status</option>
            <option value="c.first_name"  <?= $sort === 'c.first_name'  ? 'selected' : '' ?>>Sort: customer</option>
        </select>
        <button type="submit" class="btn-primary">Search</button>
    </div>
</form>

<?php if (empty($orders)): ?>
    <div class="empty">No orders found.</div>
<?php else: ?>
<div class="grid">
    <?php foreach ($orders as $o): ?>
    <div class="card">
        <div class="name">#<?= (int)$o['id'] ?></div>
        <div class="email"><?= htmlspecialchars($o['customer_name'] ?? 'Unknown') ?></div>
        <div style="font-size:13px; opacity:0.7; margin-top:6px;">
            <?= htmlspecialchars($o['order_date'] ?? '—') ?>
            <?php if ($o['delivery_date']): ?>
                → <?= htmlspecialchars($o['delivery_date']) ?>
            <?php endif; ?>
        </div>
        <?php if ($o['comment']): ?>
            <div style="font-size:12px; opacity:0.5; margin-top:6px;"><?= htmlspecialchars($o['comment']) ?></div>
        <?php endif; ?>
        <div class="card-footer">
            <span class="badge"><?= htmlspecialchars($o['status'] ?? 'unknown') ?></span>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<?php if ($pages > 1): ?>
<div class="pagination">
    <?php if ($page > 1): ?>
        <a href="?q=<?= urlencode($search) ?>&sort=<?= $sort ?>&page=<?= $page - 1 ?>">&#8592; Prev</a>
    <?php endif; ?>
    <?php for ($i = 1; $i <= $pages; $i++): ?>
        <?php if ($i === $page): ?>
            <span class="current"><?= $i ?></span>
        <?php else: ?>
            <a href="?q=<?= urlencode($search) ?>&sort=<?= $sort ?>&page=<?= $i ?>"><?= $i ?></a>
        <?php endif; ?>
    <?php endfor; ?>
    <?php if ($page < $pages): ?>
        <a href="?q=<?= urlencode($search) ?>&sort=<?= $sort ?>&page=<?= $page + 1 ?>">Next &#8594;</a>
    <?php endif; ?>
</div>
<?php endif; ?>
<?php endif; ?>