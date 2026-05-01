<?php

// Validate product ID
$productId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($productId <= 0) {
    die('Invalid product ID');
}

$product = $store->getProduct($productId);
if (!$product) {
    die('Product not found');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $store->addToCart($product['id'], isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1);
    header('Location: ?page=cart');
    exit;
}

// Use product image from database, or fallback to default images
$fashionImages = [
    'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
    'https://images.unsplash.com/photo-1496747611176-843222e1e57c?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
    'https://images.unsplash.com/photo-1483985988355-763728e1935b?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
    'https://images.unsplash.com/photo-1544966503-7cc5ac882d5f?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
    'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
    'https://images.unsplash.com/photo-1607083206968-13611e3d76db?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
    'https://images.unsplash.com/photo-1542291026-7eec264c27ff?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
    'https://images.unsplash.com/photo-1441986300917-64674bd600d8?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80'
];

// Use product image from database if available and is a URL, otherwise use fallback
if (!empty($product['image']) && (strpos($product['image'], 'http') === 0 || strpos($product['image'], '/') === 0)) {
    $imageUrl = $product['image'];
} else {
    $imageIndex = $product['id'] % count($fashionImages);
    $imageUrl = $fashionImages[$imageIndex];
}

?>

<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-lg overflow-hidden border border-slate-200">
        <div class="md:flex">
            <div class="md:w-1/2">
                <img src="<?= $imageUrl ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="w-full h-96 object-cover" onerror="this.src='<?= PLACEHOLDER_IMG ?>';">
            </div>
            <div class="md:w-1/2 p-6">
                <h2 class="text-3xl font-bold mb-4 text-slate-900"><?= htmlspecialchars($product['name']) ?></h2>
                <p class="text-slate-600 mb-4"><?= htmlspecialchars($product['description']) ?></p>
                <p class="text-2xl font-semibold text-blue-600 mb-6">$<?= number_format($product['price'], 2) ?></p>
                <form method="post" class="flex space-x-4">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700 transition-all duration-300 shadow-lg hover:shadow-xl">Add to Cart</button>
                </form>
            </div>
        </div>
    </div>
</div>