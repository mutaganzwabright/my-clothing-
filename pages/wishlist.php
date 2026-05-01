<?php
// Wishlist page - feature for saving favorite products
if (!$store->isLoggedIn()) {
    header('Location: ?page=login');
    exit;
}

// Initialize wishlist session
if (!isset($_SESSION['wishlist'])) {
    $_SESSION['wishlist'] = [];
}

// Add to wishlist
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $productId = (int)$_POST['product_id'];
    if (!in_array($productId, $_SESSION['wishlist'])) {
        $_SESSION['wishlist'][] = $productId;
    }
}

// Remove from wishlist
if (isset($_GET['remove'])) {
    $productId = (int)$_GET['remove'];
    $_SESSION['wishlist'] = array_filter($_SESSION['wishlist'], fn($id) => $id !== $productId);
}
?>

<div class="container mx-auto px-4 py-8">
    <h2 class="text-3xl font-bold mb-6 text-slate-900">My Wishlist</h2>
    
    <?php if (empty($_SESSION['wishlist'])): ?>
        <div class="bg-slate-50 rounded-lg p-12 text-center">
            <p class="text-slate-600 mb-4">Your wishlist is empty</p>
            <a href="?page=shop" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 inline-block">Continue Shopping</a>
        </div>
    <?php else: ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php
            $fashionImages = [
                'https://images.unsplash.com/photo-1542272604-787c62d465d1?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
                'https://images.unsplash.com/photo-1551028719-00167b16ebc5?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
                'https://images.unsplash.com/photo-1595777712802-a0c103e0c5c0?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
            ];
            
            foreach ($_SESSION['wishlist'] as $productId):
                $product = $store->getProduct($productId);
                if (!$product) continue;
                
                $imageUrl = !empty($product['image']) && (strpos($product['image'], 'http') === 0 || strpos($product['image'], 'data:') === 0) 
                    ? $product['image'] 
                    : $fashionImages[$product['id'] % count($fashionImages)];
            ?>
                <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 border border-slate-200">
                    <img src="<?= htmlspecialchars($imageUrl, ENT_QUOTES) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="w-full h-48 object-cover" onerror="this.src='<?= PLACEHOLDER_IMG ?>';">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2 text-slate-900"><?= htmlspecialchars($product['name']) ?></h3>
                        <p class="text-slate-600 mb-2 text-sm line-clamp-2"><?= htmlspecialchars($product['description']) ?></p>
                        <p class="text-2xl font-semibold text-blue-600 mb-4">$<?= number_format($product['price'], 2) ?></p>
                        <div class="flex gap-2">
                            <form method="POST" class="flex-1">
                                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                <button type="submit" formaction="?page=cart" class="w-full bg-blue-600 text-white px-3 py-2 rounded hover:bg-blue-700 transition-colors font-semibold text-sm">Add to Cart</button>
                            </form>
                            <a href="?page=wishlist&remove=<?= $product['id'] ?>" class="bg-red-600 text-white px-3 py-2 rounded hover:bg-red-700 transition-colors font-semibold text-sm">Remove</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
