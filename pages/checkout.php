<?php

if (!$store->isLoggedIn()) {
    header('Location: ?page=login');
    exit;
}

$total = 0;
$items = [];
$error = null;
foreach ($store->getCartItems() as $id => $qty) {
    $product = $store->getProduct($id);
    if (!$product) continue;
    $subtotal = $product['price'] * $qty;
    $total += $subtotal;
    $items[] = ['product' => $product, 'qty' => $qty, 'price' => $product['price']];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Start transaction for safe order processing
        $db->autocommit(false);
        $db->begin_transaction();
        
        $userId = (int)$_SESSION['user_id'];
        $totalAmount = (float)$total;
        
        $stmt = $db->prepare("INSERT INTO orders (user_id, total, status) VALUES (?, ?, 'paid')");
        if (!$stmt) {
            throw new Exception('Prepare failed: ' . $db->error);
        }
        
        $stmt->bind_param('id', $userId, $totalAmount);
        if (!$stmt->execute()) {
            throw new Exception('Execute failed: ' . $stmt->error);
        }
        $orderId = $db->insert_id;

        $itemStmt = $db->prepare(
            "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)"
        );
        if (!$itemStmt) {
            throw new Exception('Prepare failed: ' . $db->error);
        }

        foreach ($items as $i) {
            $oId = (int)$orderId;
            $prodId = (int)$i['product']['id'];
            $qty = (int)$i['qty'];
            $price = (float)$i['price'];
            
            $itemStmt->bind_param('iiid', $oId, $prodId, $qty, $price);
            if (!$itemStmt->execute()) {
                throw new Exception('Execute failed: ' . $itemStmt->error);
            }
        }

        $db->commit();
        $db->autocommit(true);
        
        unset($_SESSION['cart']);
        header('Location: ?page=profile');
        exit;
    } catch (Exception $e) {
        $db->rollback();
        $db->autocommit(true);
        $error = 'Order processing failed. Please try again.';
        error_log('Checkout error: ' . $e->getMessage());
    }
}

?>

<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md p-6">
        <h2 class="text-3xl font-bold mb-6 text-center">Checkout</h2>
        <?php if (isset($error)): ?>
            <p class="text-red-600 mb-4 text-center bg-red-50 p-3 rounded-md border border-red-200"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        <div class="mb-6">
            <h3 class="text-xl font-semibold mb-4">Order Summary</h3>
            <div class="space-y-2">
                <?php foreach ($items as $item): 
                    if (!$item['product']) continue;
                ?>
                    <div class="flex justify-between">
                        <span><?= htmlspecialchars($item['product']['name'] ?? 'Unknown') ?> x <?= $item['qty'] ?></span>
                        <span>$<?= number_format(($item['product']['price'] ?? 0) * $item['qty'], 2) ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
            <hr class="my-4">
            <div class="flex justify-between text-xl font-bold">
                <span>Total:</span>
                <span>$<?= number_format($total, 2) ?></span>
            </div>
        </div>
        <form method="post" class="space-y-4">
            <button type="submit" class="w-full bg-green-600 text-white py-3 px-4 rounded-md hover:bg-green-700 transition-colors text-lg font-semibold">Place Order</button>
        </form>
    </div>
</div>