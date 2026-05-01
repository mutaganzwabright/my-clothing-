<div class="relative h-screen bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1441986300917-64674bd600d8?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');">
    <div class="absolute inset-0 bg-black bg-opacity-70"></div>
    <div class="relative z-10 flex items-center justify-center h-full text-center text-white">
        <div class="hero-text">
            <h1 class="text-6xl font-bold mb-4">Explore <span class="hero-highlight">the</span> Future of Fashion</h1>
            <p class="text-xl mb-8">Discover cutting-edge styles that take you to new horizons</p>
            <a href="#collections" class="bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 transition-colors text-lg font-semibold">Shop Now</a>
        </div>
    </div>
</div>

<?php if ($store->isAdmin()): ?>
    <div class="container mx-auto px-4 py-6">
        <div class="bg-blue-50 text-slate-900 rounded-lg p-4 text-center shadow-md border border-slate-200">
            <a href="<?= BASE_URL ?>/admin/dashboard.php" class="font-semibold inline-block">Open Admin Dashboard</a>
        </div>
    </div>
<?php endif; ?>

<div id="collections" class="container mx-auto px-4 py-16">
    <h2 class="text-4xl font-bold mb-8 text-center text-slate-900">Latest Collections</h2>

    <p class="text-slate-600 mb-12 text-center text-lg">
        Browse our newest fashion arrivals inspired by the cosmos.
    </p>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php
        $search = $_GET['search'] ?? '';
        $fashionImages = [
            'https://i.pinimg.com/1200x/ae/7c/4d/ae7c4dd14d6ec6862833176d6e87dbce.jpg',
            'https://images.unsplash.com/photo-1542272604-787c62d465d1?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
            'https://images.unsplash.com/photo-1551028719-00167b16ebc5?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
            'https://images.unsplash.com/photo-1595777712802-a0c103e0c5c0?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
            'https://images.unsplash.com/photo-1556821552-23e18e60ca32?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
            'https://images.unsplash.com/photo-1612336307429-8a88e8d08823?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
            'https://images.unsplash.com/photo-1594938298603-c8148c4dae35?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
            'https://images.unsplash.com/photo-1507272137935-68ec59c6b9a3?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
            'https://images.unsplash.com/photo-1591195853644-52ed2e3e3f60?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
            'https://images.unsplash.com/photo-1544236468-86e4db8c0acd?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
            'https://images.unsplash.com/photo-1520438408652-e4c86b20d251?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
            'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80'
        ];

        // decrease the number of homepage products shown and use product-specific images when available
        $products = $store->getProducts($search, 7);

        foreach ($products as $product):
            // Use the classical white t-shirt URL when that product appears in the collection.
            if ($product['name'] === 'Classic White T-Shirt') {
                $imageUrl = 'https://i.pinimg.com/1200x/ae/7c/4d/ae7c4dd14d6ec6862833176d6e87dbce.jpg';
            } elseif (!empty($product['image']) && (strpos($product['image'], 'http') === 0 || strpos($product['image'], '/') === 0 || strpos($product['image'], 'data:') === 0)) {
                $imageUrl = $product['image'];
            } else {
                $imageUrl = $fashionImages[$product['id'] % count($fashionImages)];
            }
        ?>
            <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 border border-slate-200 card-hover">
                <img src="<?= htmlspecialchars($imageUrl, ENT_QUOTES) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="w-full h-48 object-cover" onerror="this.src='<?= PLACEHOLDER_IMG ?>';">
                <div class="p-6">
                    <h3 class="text-xl font-semibold mb-2 text-slate-900"><?= htmlspecialchars($product['name']) ?></h3>
                    <p class="text-slate-600 mb-2">$<?= number_format($product['price'], 2) ?></p>
                    <?php if (isset($product['stock'])): ?>
                        <p class="text-slate-500 mb-4">Stock: <?= (int)$product['stock'] ?> available</p>
                    <?php endif; ?>
                    <a href="?page=product_detail&id=<?= $product['id'] ?>" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition-colors inline-block font-semibold">View Details</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- What We Do Section -->
<section class="bg-slate-50 py-16">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-slate-900 mb-4">What We Do</h2>
            <p class="text-slate-600 text-lg">Bringing you the latest in fashion technology and style</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center bg-white rounded-3xl p-8 shadow-md border border-slate-200">
                <div class="bg-blue-600 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-rocket text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-slate-900 mb-2">Innovative Designs</h3>
                <p class="text-slate-600">Cutting-edge fashion that pushes boundaries</p>
            </div>
            <div class="text-center bg-white rounded-3xl p-8 shadow-md border border-slate-200">
                <div class="bg-blue-600 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-globe text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-slate-900 mb-2">Global Reach</h3>
                <p class="text-slate-600">Fashion for everyone, everywhere</p>
            </div>
            <div class="text-center bg-white rounded-3xl p-8 shadow-md border border-slate-200">
                <div class="bg-blue-600 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-star text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-slate-900 mb-2">Quality Assurance</h3>
                <p class="text-slate-600">Premium materials and craftsmanship</p>
            </div>
        </div>
    </div>
</section>

<!-- News Section -->
<section class="py-16 bg-slate-50">
    <div class="container mx-auto px-4">
        <h2 class="text-4xl font-bold text-center text-slate-900 mb-12">News</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <div class="bg-white rounded-lg overflow-hidden shadow-lg border border-slate-200">
                <img src="https://i.pinimg.com/1200x/8c/c2/72/8cc27283dbb2d5498d74fc28a23a6d8f.jpg" alt="New Collection" class="w-full h-48 object-cover" onerror="this.src='<?= PLACEHOLDER_IMG ?>';">
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-slate-900 mb-2">New Collection Launch</h3>
                    <p class="text-slate-600 mb-4">Discover our latest space-inspired designs</p>
                    <a href="#" class="text-blue-600 hover:text-blue-700">Read More</a>
                </div>
            </div>
            <div class="bg-white rounded-lg overflow-hidden shadow-lg border border-slate-200">
                <img src="https://i.pinimg.com/1200x/d7/9a/16/d79a16df7a06ca44991be375ec58edc5.jpg" alt="Fashion Trends" class="w-full h-48 object-cover" onerror="this.src='<?= PLACEHOLDER_IMG ?>';">
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-slate-900 mb-2">Fashion Trends 2026</h3>
                    <p class="text-slate-600 mb-4">What's hot in fashion this year</p>
                    <a href="#" class="text-blue-600 hover:text-blue-700">Read More</a>
                </div>
            </div>
            <div class="bg-white rounded-lg overflow-hidden shadow-lg border border-slate-200">
                <img src="https://i.pinimg.com/1200x/9b/c7/2b/9bc72b5b74f72b0ec761fac644dc98a7.jpg" alt="Events" class="w-full h-48 object-cover" onerror="this.src='<?= PLACEHOLDER_IMG ?>';">
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-slate-900 mb-2">Upcoming Events</h3>
                    <p class="text-slate-600 mb-4">Join us for fashion shows and launches</p>
                    <a href="#" class="text-blue-600 hover:text-blue-700">Read More</a>
                </div>
            </div>
            <div class="bg-white rounded-lg overflow-hidden shadow-lg border border-slate-200">
                <img src="https://i.pinimg.com/736x/7e/8d/06/7e8d0647d2f0384d3f7e8d6368a24748.jpg" alt="Sustainable Fashion" class="w-full h-48 object-cover" onerror="this.src='<?= PLACEHOLDER_IMG ?>';">
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-slate-900 mb-2">Sustainable Fashion</h3>
                    <p class="text-slate-600 mb-4">Our commitment to eco-friendly materials</p>
                    <a href="#" class="text-blue-600 hover:text-blue-700">Read More</a>
                </div>
            </div>
            <div class="bg-white rounded-lg overflow-hidden shadow-lg border border-slate-200">
                <img src="https://sw13716.sfstatic.io/upload_dir/shop/_thumbs/Space-Skinne-spotlampe-sort-LOOM-Design.w293.h293.fill.jpg" alt="Designer Spotlight" class="w-full h-48 object-cover" onerror="this.src='<?= PLACEHOLDER_IMG ?>';">
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-slate-900 mb-2">Designer Spotlight</h3>
                    <p class="text-slate-600 mb-4">Meet the artists behind our collections</p>
                    <a href="#" class="text-blue-600 hover:text-blue-700">Read More</a>
                </div>
            </div>
            <div class="bg-white rounded-lg overflow-hidden shadow-lg border border-slate-200">
                <img src="data:image/jpeg;base64,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" alt="Seasonal Sale" class="w-full h-48 object-cover" onerror="this.src='<?= PLACEHOLDER_IMG ?>';">
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-slate-900 mb-2">Seasonal Sale</h3>
                    <p class="text-slate-600 mb-4">Up to 50% off on selected items</p>
                    <a href="#" class="text-blue-600 hover:text-blue-700">Read More</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Images Section -->
<section class="bg-slate-50 py-16">
    <div class="container mx-auto px-4">
        <h2 class="text-4xl font-bold text-center text-slate-900 mb-12">Featured Images</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            <img src="https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Fashion Model" class="w-full h-48 object-cover rounded-lg" onerror="this.src='<?= PLACEHOLDER_IMG ?>';">
            <img src="https://images.unsplash.com/photo-1542272604-787c62d465d1?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Designer Clothing" class="w-full h-48 object-cover rounded-lg" onerror="this.src='<?= PLACEHOLDER_IMG ?>';">
            <img src="https://images.unsplash.com/photo-1551028719-00167b16ebc5?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Fashion Show" class="w-full h-48 object-cover rounded-lg" onerror="this.src='<?= PLACEHOLDER_IMG ?>';">
            <img src="https://images.unsplash.com/photo-1595777712802-a0c103e0c5c0?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Modern Fashion" class="w-full h-48 object-cover rounded-lg" onerror="this.src='<?= PLACEHOLDER_IMG ?>';">
            <img src="https://images.unsplash.com/photo-1503341455253-b2e723bb3dbb?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Elegant Outfit" class="w-full h-48 object-cover rounded-lg" onerror="this.src='<?= PLACEHOLDER_IMG ?>';">
            <img src="https://images.unsplash.com/photo-1495121605193-b116b5b9c5e8?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Streetwear Style" class="w-full h-48 object-cover rounded-lg" onerror="this.src='<?= PLACEHOLDER_IMG ?>';">
            <img src="https://images.unsplash.com/photo-1512436991641-6745cdb1723f?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Runway Look" class="w-full h-48 object-cover rounded-lg" onerror="this.src='<?= PLACEHOLDER_IMG ?>';">
            <img src="https://images.unsplash.com/photo-1495121605193-b116b5b9c5e8?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Style Collection" class="w-full h-48 object-cover rounded-lg" onerror="this.src='<?= PLACEHOLDER_IMG ?>';">
        </div>
    </div>
</section>
