<?php

$total = 0;
$fashionImages = [
    'https://images.unsplash.com/photo-1445205170230-053b83016050?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80',
    'https://images.unsplash.com/photo-1496747611176-843222e1e57c?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80',
    'https://images.unsplash.com/photo-1483985988355-763728e1935b?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80',
    'https://images.unsplash.com/photo-1544966503-7cc5ac882d5f?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80',
    'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80',
    'https://images.unsplash.com/photo-1607083206968-13611e3d76db?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80',
    'https://images.unsplash.com/photo-1542291026-7eec264c27ff?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80',
    'https://images.unsplash.com/photo-1441986300917-64674bd600d8?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80'
];

?>

<div class="container mx-auto px-4 py-8">
    <h2 class="text-3xl font-bold mb-6 text-slate-900">Your Cart</h2>
    <?php if (empty($store->getCartItems())): ?>
        <p class="text-slate-600">Your cart is empty.</p>
    <?php else: ?>
        <div class="bg-white rounded-lg shadow-lg overflow-hidden border border-slate-200">
            <table class="w-full">
                <thead class="bg-slate-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Product</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Quantity</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Price</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    <?php foreach ($store->getCartItems() as $id => $qty):
                        $product = $store->getProduct($id);
                        if (!$product) continue;
                        $subtotal = $product['price'] * $qty;
                        $total += $subtotal;
                        $imageIndex = $product['id'] % count($fashionImages);
                        $imageUrl = $fashionImages[$imageIndex];
                    ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <img src="<?= $imageUrl ?>" alt="<?= htmlspecialchars($product['name'] ?? 'Product') ?>" class="w-12 h-12 object-cover rounded" onerror="this.src='<?= PLACEHOLDER_IMG ?>';">
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-slate-900"><?= htmlspecialchars($product['name'] ?? 'Unknown Product') ?></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600"><?= $qty ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">$<?= number_format($product['price'] ?? 0, 2) ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">$<?= number_format($subtotal, 2) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="mt-6 flex justify-between items-center">
            <h3 class="text-2xl font-bold text-slate-900">Total: $<?= number_format($total, 2) ?></h3>
            <a href="?page=checkout" class="bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700 transition-all duration-300 shadow-lg hover:shadow-xl">Checkout</a>
        </div>
    <?php endif; ?>
</div>