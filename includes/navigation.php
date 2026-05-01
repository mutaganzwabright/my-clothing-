<nav class="bg-white shadow-lg">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center py-4">
            <div class="text-xl font-bold text-slate-900 flex items-center">
                <i class="fas fa-crown text-yellow-400 mr-2"></i>
                <span class="text-slate-900">Elite</span>
                <span class="text-blue-700 ml-1">Wear</span>
            </div>
            <div class="hidden md:flex items-center space-x-6">
                <a href="<?= BASE_URL ?>" class="text-slate-900 hover:text-blue-700 transition-colors">Home</a>
                <div class="relative group">
                    <a href="#" class="text-slate-900 hover:text-blue-700 transition-colors">Shop <i class="fas fa-chevron-down ml-1"></i></a>
                    <div class="absolute left-0 mt-2 w-48 bg-white rounded-md shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 border border-slate-200">
                        <a href="<?= BASE_URL ?>/?page=home" class="block px-4 py-2 text-slate-900 hover:text-blue-700 hover:bg-blue-50">All Products</a>
                        <a href="#" class="block px-4 py-2 text-slate-900 hover:text-blue-700 hover:bg-blue-50">New Arrivals</a>
                        <a href="#" class="block px-4 py-2 text-slate-900 hover:text-blue-700 hover:bg-blue-50">Sale</a>
                    </div>
                </div>
                <a href="<?= BASE_URL ?>/?page=about" class="text-slate-900 hover:text-blue-700 transition-colors">About</a>
                <a href="<?= BASE_URL ?>/?page=contact" class="text-slate-900 hover:text-blue-700 transition-colors">Contact</a>
                <a href="<?= BASE_URL ?>/?page=cart" class="text-slate-900 hover:text-blue-700 transition-colors">Cart</a>
                <?php if ($store->isLoggedIn()): ?>
                    <a href="<?= BASE_URL ?>/?page=profile" class="text-slate-900 hover:text-blue-700 transition-colors">Profile</a>
                    <?php if ($store->isAdmin()): ?>
                        <a href="<?= BASE_URL ?>/admin/dashboard.php" class="text-slate-900 hover:text-blue-700 transition-colors">Admin</a>
                    <?php endif; ?>
                    <a href="<?= BASE_URL ?>/?page=logout" class="text-slate-900 hover:text-blue-700 transition-colors">Logout</a>
                <?php else: ?>
                    <a href="<?= BASE_URL ?>/?page=login" class="text-slate-900 hover:text-blue-700 transition-colors">Login</a>
                    <a href="<?= BASE_URL ?>/?page=register" class="text-slate-900 hover:text-blue-700 transition-colors">Register</a>
                <?php endif; ?>
            </div>
            <div class="flex items-center space-x-4">
                <form method="GET" action="<?= BASE_URL ?>" class="flex">
                    <input type="hidden" name="page" value="home">
                    <input type="text" name="search" placeholder="Search..." class="px-3 py-2 border border-blue-700 rounded-l-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 bg-blue-800 text-white placeholder-blue-300 text-sm" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                    <button type="submit" class="bg-blue-700 text-white px-4 py-2 rounded-r-md hover:bg-blue-800 transition-colors">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>