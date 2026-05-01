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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$name = trim($_POST['name'] ?? '');
	$price = (float)($_POST['price'] ?? 0);
	$desc = trim($_POST['description'] ?? '');
	
	// Validate inputs
	if (empty($name) || $price <= 0) {
		$error = 'Name and valid price are required';
	} else {
		$image = null;
		if (!empty($_FILES['image']['name'])) {
			// Validate file upload
			$allowed = ['jpg', 'jpeg', 'png', 'gif'];
			$filename = basename($_FILES['image']['name']);
			$ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
			
			if (!in_array($ext, $allowed)) {
				$error = 'Only image files are allowed';
			} elseif ($_FILES['image']['size'] > 5000000) { // 5MB limit
				$error = 'Image file too large';
			} else {
				// Generate safe filename
				$image = uniqid() . '.' . $ext;
				if (!move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ . '/../uploads/' . $image)) {
					$error = 'Failed to upload image';
					$image = null;
				}
			}
		}
		
		if (!isset($error)) {
			$stmt = $db->prepare("INSERT INTO products (name, description, price, image) VALUES (?,?,?,?)");
			if (!$stmt) {
				$error = 'Database error: ' . $db->error;
			} else {
				$stmt->bind_param('ssds', $name, $desc, $price, $image);
				if ($stmt->execute()) {
					header('Location: products.php');
					exit;
				} else {
					$error = 'Failed to add product: ' . $stmt->error;
				}
			}
		}
	}

// Delete
if (isset($_GET['delete'])) {
	$id = (int)$_GET['delete'];
	$stmt = $db->prepare("DELETE FROM products WHERE id=?");
	$stmt->bind_param('i', $id);
	$stmt->execute();
	header('Location: products.php');
	exit;
}

// no limit used for admin management
$products = $store->getProducts();
?>


<div class="container mx-auto px-4 py-8">
	<h2 class="text-2xl font-bold mb-6 text-slate-900">Manage Products</h2>
	<?php if (isset($error)): ?>
		<p class="text-red-600 mb-4 text-center bg-red-50 p-3 rounded-md border border-red-200"><?= htmlspecialchars($error) ?></p>
	<?php endif; ?>

	<form method="post" enctype="multipart/form-data" class="mb-6 bg-white p-4 rounded-lg shadow-sm">
		<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
			<input name="name" placeholder="Product name" required class="px-3 py-2 border rounded-md">
			<input name="price" type="number" step="0.01" required placeholder="Price" class="px-3 py-2 border rounded-md">
			<input type="file" name="image" accept=".jpg,.jpeg,.png,.gif" class="px-3 py-2">
		</div>
		<div class="mt-4">
			<textarea name="description" placeholder="Description" class="w-full px-3 py-2 border rounded-md"></textarea>
		</div>
		<div class="mt-4">
			<button class="bg-amber-600 text-white px-4 py-2 rounded-md">Add Product</button>
		</div>
	</form>

	<hr class="my-6">
	<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
		<?php foreach ($products as $p): ?>
		<div class="bg-white p-4 rounded shadow-sm">
			<div class="font-medium text-slate-900"><?= htmlspecialchars($p['name']) ?></div>
			<div class="text-sm text-slate-600">$<?= number_format($p['price'],2) ?></div>
			<div class="mt-2">
				<a href="?delete=<?= $p['id'] ?>" class="text-red-600">Delete</a>
			</div>
		</div>
		<?php endforeach; ?>
	</div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>