<?php if ($withOrders): ?>

<p><a href="/customers">Back to list</a></p>
<ul>
    <?php foreach ($customers as $c): ?>
    <li>
        <strong><?= htmlspecialchars($c->fullName()) ?></strong>
        (<?= htmlspecialchars($c->email) ?>)
        <ul>
            <?php if (!empty($c->orders)): ?>
                <?php foreach ($c->orders as $o): ?>
                <li>
                    #<?= $o->id ?> —
                    <?= htmlspecialchars($o->status ?? '—') ?> —
                    <?= htmlspecialchars($o->order_date ?? '—') ?>
                </li>
                <?php endforeach; ?>
            <?php else: ?>
                <li>No orders</li>
            <?php endif; ?>
        </ul>
    </li>
    <?php endforeach; ?>
</ul>

<?php else: ?>

<form method="GET" action="/customers" style="margin-bottom:16px">
    <input type="text" name="q" value="<?= htmlspecialchars($search) ?>" placeholder="Search…">
    <button type="submit">Search</button>
    <a href="/customers?with-orders=full">Show with orders</a>
    <a href="/export/customers">Export</a>
</form>

<form method="POST" action="/customers/add" style="margin-bottom:16px">
    <input type="text"   name="first_name" placeholder="First name" required>
    <input type="text"   name="last_name"  placeholder="Last name"  required>
    <input type="email"  name="email"      placeholder="Email"      required>
    <input type="date"   name="birth_date">
    <input type="number" name="points" placeholder="Points" value="0" min="0">
    <button type="submit">Add</button>
</form>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Birth date</th>
            <th>Points</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($customers as $c): ?>
        <tr>
            <td><?= $c->id ?></td>
            <td><?= htmlspecialchars($c->fullName()) ?></td>
            <td><?= htmlspecialchars($c->email) ?></td>
            <td><?= htmlspecialchars($c->birth_date ?? '—') ?></td>
            <td><?= $c->points ?></td>
            <td><a href="/customers/delete?id=<?= $c->id ?>"
                   onclick="return confirm('Delete?')">Delete</a></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php endif; ?>