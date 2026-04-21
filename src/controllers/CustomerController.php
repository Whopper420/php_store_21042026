<?php
require_once __DIR__ . '/../../db/DB.php';
require_once __DIR__ . '/../../views/layout.php';

class CustomerController
{
    private static int $perPage = 9;

    public static function index(): void
    {
        $flash = self::getFlash();

        $search = trim($_GET['q'] ?? '');
        $sort   = in_array($_GET['sort'] ?? '', ['first_name', 'email']) ? $_GET['sort'] : 'first_name';
        $page   = max(1, (int)($_GET['page'] ?? 1));
        $offset = ($page - 1) * self::$perPage;

        $like = '%' . self::$pdo()->real_escape_string($search) . '%';
        $where = $search
            ? "WHERE CONCAT(first_name,' ',last_name) LIKE '$like' OR email LIKE '$like'"
            : '';

        $total  = self::getPdo()->query("SELECT COUNT(*) AS n FROM customers $where")->fetch_assoc()['n'];
        $pages  = max(1, (int)ceil($total / self::$perPage));
        $page   = min($page, $pages);

        $result = DB::query("SELECT * FROM customers $where ORDER BY $sort ASC LIMIT $offset, " . self::$perPage);
        $customers = [];
        while ($row = $result->fetch_assoc()) {
            $customers[] = $row;
        }

        ob_start(); ?>

        <div class="stats">
            <div class="stat-card">
                <div class="label">Total customers</div>
                <div class="value"><?= (int)$total ?></div>
            </div>
            <div class="stat-card">
                <div class="label">Page</div>
                <div class="value"><?= $page ?> / <?= $pages ?></div>
            </div>
        </div>

        <div class="add-form">
            <h2>+ Add customer</h2>
            <form method="POST" action="/customers/add">
                <div class="form-row">
                    <input type="text"   name="first_name" placeholder="First name" required maxlength="80">
                    <input type="text"   name="last_name"  placeholder="Last name"  required maxlength="80">
                    <input type="email"  name="email"      placeholder="Email"      required maxlength="160">
                    <button type="submit" class="btn-primary">Add</button>
                </div>
            </form>
        </div>

        <form method="GET" action="/customers">
            <div class="controls">
                <input type="text" name="q" value="<?= htmlspecialchars($search) ?>" placeholder="Search by name or email…">
                <select name="sort" onchange="this.form.submit()">
                    <option value="first_name" <?= $sort === 'first_name' ? 'selected' : '' ?>>Sort: name</option>
                    <option value="email"      <?= $sort === 'email'      ? 'selected' : '' ?>>Sort: email</option>
                </select>
                <button type="submit" class="btn-primary">Search</button>
            </div>
        </form>

        <?php if (empty($customers)): ?>
            <div class="empty">No customers found.</div>
        <?php else: ?>
        <div class="grid">
            <?php foreach ($customers as $c):
                $initials = mb_strtoupper(mb_substr($c['first_name'], 0, 1) . mb_substr($c['last_name'], 0, 1));
                $deleteUrl = '/customers/delete?id=' . (int)$c['id']
                    . '&q=' . urlencode($search)
                    . '&sort=' . urlencode($sort)
                    . '&page=' . $page;
            ?>
                <div class="card">
                    <div class="avatar"><?= htmlspecialchars($initials) ?></div>
                    <div class="name"><?= htmlspecialchars($c['first_name'] . ' ' . $c['last_name']) ?></div>
                    <div class="email"><?= htmlspecialchars($c['email']) ?></div>
                    <div class="card-footer">
                        <span class="badge">Customer</span>
                        <a href="<?= htmlspecialchars($deleteUrl) ?>" class="btn-delete"
                           onclick="return confirm('Delete this customer?')">Delete</a>
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

        <?php
        $content = ob_get_clean();
        layout('Klienti', $content, $flash);
    }

    public static function add(): void
    {
        $first = trim($_POST['first_name'] ?? '');
        $last  = trim($_POST['last_name']  ?? '');
        $email = trim($_POST['email']      ?? '');

        if (!$first || !$last || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            self::setFlash('error', 'Invalid data — please fill all fields correctly.');
            header('Location: /customers');
            exit;
        }

        $pdo = self::getPdo();
        $stmt = $pdo->prepare("INSERT INTO customers (first_name, last_name, email) VALUES (?, ?, ?)");
        $stmt->bind_param('sss', $first, $last, $email);

        if ($stmt->execute()) {
            self::setFlash('success', "Customer $first $last added successfully!");
        } else {
            self::setFlash('error', 'Could not add customer: ' . $pdo->error);
        }

        header('Location: /customers');
        exit;
    }

    public static function delete(): void
    {
        $id = (int)($_GET['id'] ?? 0);
        if ($id > 0) {
            $stmt = self::getPdo()->prepare("DELETE FROM customers WHERE id = ?");
            $stmt->bind_param('i', $id);
            $stmt->execute();
            self::setFlash('success', 'Customer deleted.');
        }
        $q    = urlencode($_GET['q']   ?? '');
        $sort = urlencode($_GET['sort'] ?? 'first_name');
        $page = (int)($_GET['page'] ?? 1);
        header("Location: /customers?q=$q&sort=$sort&page=$page");
        exit;
    }

    private static function getPdo(): mysqli
    {
        return DB::$pdo;
    }

    private static function setFlash(string $type, string $msg): void
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $_SESSION['flash'] = compact('type', 'msg');
    }

    private static function getFlash(): ?array
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $flash = $_SESSION['flash'] ?? null;
        unset($_SESSION['flash']);
        return $flash;
    }
}