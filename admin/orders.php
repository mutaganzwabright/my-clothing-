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
?>
<?php
if (isset($_POST['status']) && isset($_POST['id'])) {
	$allowed = ['pending','paid','shipped','delivered'];
	$status = in_array($_POST['status'], $allowed) ? $_POST['status'] : 'pending';
	$id = (int) $_POST['id'];
	$stmt = $db->prepare("UPDATE orders SET status=? WHERE id=?");
	$stmt->bind_param('si', $status, $id);
	$stmt->execute();
	header('Location: orders.php');
	exit;
}

$orders = $db->query("SELECT * FROM orders ORDER BY created_at DESC");

// Create demo orders for testing when requested (admin only)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_demo'])) {
	// find a user to assign the demo order to
	$userRow = $db->query("SELECT id FROM users LIMIT 1")->fetch_assoc();
	$userId = $userRow['id'] ?? 1;

	// find a product to include
	$prod = $db->query("SELECT id, price FROM products LIMIT 1")->fetch_assoc();
	if ($prod) {
		$productId = $prod['id'];
		$price = (float)$prod['price'];
	} else {
		$productId = 1;
		$price = 19.99;
	}

	$total = $price * 2;
	$stmt = $db->prepare("INSERT INTO orders (user_id, total, status) VALUES (?, ?, 'pending')");
	$stmt->bind_param('id', $userId, $total);
	$stmt->execute();
	$orderId = $db->insert_id;

	$stmt2 = $db->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
	$qty = 2;
	$stmt2->bind_param('iiid', $orderId, $productId, $qty, $price);
	$stmt2->execute();

	header('Location: orders.php');
	exit;
}
?>


<div class="container mx-auto px-4 py-8">
	<h2 class="text-2xl font-bold mb-6 text-slate-900">Manage Orders</h2>
	<?php while ($o = $orders->fetch_assoc()): ?>
	<form method="post" class="mb-4 bg-white p-4 rounded-lg shadow-sm border">
		<div class="flex items-center justify-between">
			<div>
				<div class="font-medium text-slate-900">Order #<?= $o['id'] ?> — $<?= number_format($o['total'],2) ?></div>
				<div class="text-sm text-slate-600">Placed: <?= date('M d, Y', strtotime($o['created_at'])) ?> — User ID: <?= $o['user_id'] ?></div>
			</div>
			<div class="flex items-center space-x-3">
				<select name="status" class="px-3 py-2 border rounded-md">
					<?php foreach (['pending','paid','shipped','delivered'] as $s): ?>
						<option value="<?= $s ?>" <?= $o['status']==$s?'selected':'' ?>><?= ucfirst($s) ?></option>
					<?php endforeach; ?>
				</select>
				<input type="hidden" name="id" value="<?= $o['id'] ?>">
				<button class="bg-amber-600 text-white px-4 py-2 rounded-md hover:bg-amber-700">Update</button>
			</div>
		</div>
	</form>
	<?php endwhile; ?>
</div>

<?php require_once '../includes/footer.php'; ?>