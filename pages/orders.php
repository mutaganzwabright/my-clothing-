<?php
// Orders page - shows user's orders (same as profile orders section)
if (!$store->isLoggedIn()) {
    header('Location: ?page=login');
    exit;
}

$stmt = $db->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC");
$stmt->bind_param('i', $_SESSION['user_id']);
$stmt->execute();
$orders = $stmt->get_result();
?>

<div class="container mx-auto px-4 py-8">
    <h2 class="text-3xl font-bold mb-6 text-slate-900">Your Orders</h2>
    <?php if ($orders->num_rows == 0): ?>
        <p class="text-slate-600">You have no orders yet.</p>
    <?php else: ?>
        <div class="space-y-4">
            <?php while ($order = $orders->fetch_assoc()): ?>
                <div class="bg-white rounded-lg shadow-md p-6 border border-slate-200">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-xl font-semibold text-slate-900">Order #<?= (int)$order['id'] ?></h3>
                        <span class="px-3 py-1 rounded-full text-sm font-medium
                            <?php if ($order['status'] == 'paid'): ?>bg-emerald-100 text-emerald-800
                            <?php elseif ($order['status'] == 'pending'): ?>bg-slate-100 text-slate-800
                            <?php elseif ($order['status'] == 'shipped'): ?>bg-amber-100 text-amber-800
                            <?php else: ?>bg-slate-100 text-slate-800<?php endif; ?>">
                            <?= ucfirst(htmlspecialchars($order['status'])) ?>
                        </span>
                    </div>
                    <p class="text-slate-600 mb-2">Date: <?= date('F j, Y', strtotime($order['created_at'])) ?></p>
                    <p class="text-lg font-semibold text-blue-600">Total: $<?= number_format($order['total'], 2) ?></p>
                </div>
            <?php endwhile; ?>
        </div>
    <?php endif; ?>
</div>
