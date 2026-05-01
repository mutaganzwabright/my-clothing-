<?php
// Shop page - displays all products with optional filtering
$search = $_GET['search'] ?? '';
$filter = $_GET['filter'] ?? '';

$products = $store->getProducts($search);
?>

<div class="container mx-auto px-4 py-8">
    <h2 class="text-4xl font-bold mb-8 text-center text-slate-900">Shop</h2>
    
    <div class="mb-8">
        <form method="GET" action="<?= BASE_URL ?>" class="flex gap-4 flex-wrap">
            <input type="hidden" name="page" value="shop">
            <input type="text" name="search" placeholder="Search products..." class="px-4 py-2 border border-slate-300 rounded-md flex-grow" value="<?= htmlspecialchars($search) ?>">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700">Search</button>
        </form>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php
        $fashionImages = [
            'https://images.unsplash.com/photo-1542272604-787c62d465d1?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
            'https://images.unsplash.com/photo-1551028719-00167b16ebc5?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
            'https://images.unsplash.com/photo-1595777712802-a0c103e0c5c0?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
        ];
        
        foreach ($products as $product):
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
                    <a href="?page=product_detail&id=<?= $product['id'] ?>" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition-colors inline-block font-semibold">View Details</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
