<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/database.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/navigation.php';

if (!$store->isLoggedIn()) {
    header('Location: ' . BASE_URL . '/?page=login');
    exit;
}
if (!$store->isAdmin()) die('Access denied. You must be an administrator to access this page.');

// Handle role change or delete
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete']) && isset($_POST['id'])) {
        $id = (int)$_POST['id'];
        $stmt = $db->prepare("DELETE FROM users WHERE id=?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        header('Location: users.php');
        exit;
    }
    if (isset($_POST['role']) && isset($_POST['id'])) {
        $id = (int)$_POST['id'];
        $role = in_array($_POST['role'], ['user','admin']) ? $_POST['role'] : 'user';
        $stmt = $db->prepare("UPDATE users SET role=? WHERE id=?");
        $stmt->bind_param('si', $role, $id);
        $stmt->execute();
        header('Location: users.php');
        exit;
    }
}

$users = $db->query("SELECT id, username, email, role, created_at FROM users ORDER BY created_at DESC");
?>

<div class="container mx-auto px-4 py-8">
    <h2 class="text-2xl font-bold mb-6 text-slate-900">User Management</h2>

    <div class="grid grid-cols-1 gap-4">
        <?php while ($u = $users->fetch_assoc()): ?>
        <div class="bg-white p-4 rounded shadow-sm flex items-center justify-between">
            <div>
                <div class="font-medium text-slate-900"><?= htmlspecialchars($u['username']) ?> (<?= htmlspecialchars($u['email']) ?>)</div>
                <div class="text-sm text-slate-600">Joined: <?= date('M d, Y', strtotime($u['created_at'])) ?></div>
            </div>
            <div class="flex items-center space-x-3">
                <form method="post" class="flex items-center space-x-2">
                    <input type="hidden" name="id" value="<?= $u['id'] ?>">
                    <select name="role" class="px-2 py-1 border rounded-md">
                        <option value="user" <?= $u['role']=='user'?'selected':'' ?>>User</option>
                        <option value="admin" <?= $u['role']=='admin'?'selected':'' ?>>Admin</option>
                    </select>
                    <button class="bg-emerald-600 text-white px-3 py-1 rounded-md">Update</button>
                </form>
                <form method="post" onsubmit="return confirm('Delete this user?');">
                    <input type="hidden" name="id" value="<?= $u['id'] ?>">
                    <input type="hidden" name="delete" value="1">
                    <button class="bg-red-600 text-white px-3 py-1 rounded-md">Delete</button>
                </form>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>