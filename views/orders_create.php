<p><a href="/orders">Back to orders</a></p>

<form method="POST" action="/orders/store">
    <table>
        <tr>
            <td><label>Customer</label></td>
            <td>
                <select name="customer_id" required>
                    <option value="">— select customer —</option>
                    <?php foreach ($customers as $c): ?>
                    <option value="<?= $c->id ?>">
                        <?= htmlspecialchars($c->fullName()) ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>
        <tr>
            <td><label>Order date</label></td>
            <td><input type="date" name="order_date" required></td>
        </tr>
        <tr>
            <td><label>Delivery date</label></td>
            <td><input type="date" name="delivery_date"></td>
        </tr>
        <tr>
            <td><label>Status</label></td>
            <td><input type="text" name="status" placeholder="e.g. pending"></td>
        </tr>
        <tr>
            <td><label>Comment</label></td>
            <td><input type="text" name="comment" placeholder="Optional"></td>
        </tr>
        <tr>
            <td></td>
            <td><button type="submit">Create order</button></td>
        </tr>
    </table>
</form>