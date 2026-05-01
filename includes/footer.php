    </main>

    <!-- Footer -->
    <footer class="bg-slate-950 text-slate-200">
        <div class="container mx-auto px-4 py-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-8">

                <!-- Company Info -->
                <div>
                    <h3 class="text-lg font-bold text-white mb-4 flex items-center">
                        <i class="fas fa-crown text-yellow-400 mr-2"></i>
                        <span class="text-white">Elite</span>
                        <span class="text-blue-400 ml-1">Wear</span>
                    </h3>

                    <p class="text-slate-400 mb-4 text-sm">
                        Your one-stop destination for premium fashion clothing.
                        We bring you the latest trends with quality and style.
                    </p>

                    <div class="flex space-x-4">
                        <a href="https://www.facebook.com" target="_blank" rel="noopener noreferrer" class="text-slate-400 hover:text-blue-400 transition-colors">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="https://twitter.com" target="_blank" rel="noopener noreferrer" class="text-slate-400 hover:text-blue-400 transition-colors">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="https://www.instagram.com" target="_blank" rel="noopener noreferrer" class="text-slate-400 hover:text-blue-400 transition-colors">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="https://www.youtube.com" target="_blank" rel="noopener noreferrer" class="text-slate-400 hover:text-blue-400 transition-colors">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                </div>

                <!-- Shop -->
                <div>
                    <h4 class="text-lg font-bold text-white mb-4">Shop</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="<?= BASE_URL ?>" class="text-slate-400 hover:text-blue-400 transition-colors">All Products</a></li>
                        <li><a href="<?= BASE_URL ?>/?page=home&filter=new" class="text-slate-400 hover:text-blue-400 transition-colors">New Arrivals</a></li>
                        <li><a href="<?= BASE_URL ?>/?page=home&filter=sale" class="text-slate-400 hover:text-blue-400 transition-colors">Sale</a></li>
                        <li><a href="<?= BASE_URL ?>/?page=home&filter=collections" class="text-slate-400 hover:text-blue-400 transition-colors">Collections</a></li>
                    </ul>
                </div>

                <!-- About -->
                <div>
                    <h4 class="text-lg font-bold text-white mb-4">About</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="<?= BASE_URL ?>/?page=about" class="text-slate-400 hover:text-blue-400 transition-colors">Our Story</a></li>
                        <li><a href="#" class="text-slate-400 hover:text-blue-400 transition-colors">Careers</a></li>
                        <li><a href="#" class="text-slate-400 hover:text-blue-400 transition-colors">Press</a></li>
                        <li><a href="#" class="text-slate-400 hover:text-blue-400 transition-colors">Investors</a></li>
                    </ul>
                </div>

                <!-- Support -->
                <div>
                    <h4 class="text-lg font-bold text-white mb-4">Support</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="text-slate-400 hover:text-blue-400 transition-colors">Help Center</a></li>
                        <li><a href="#" class="text-slate-400 hover:text-blue-400 transition-colors">Size Guide</a></li>
                        <li><a href="#" class="text-slate-400 hover:text-blue-400 transition-colors">Shipping</a></li>
                        <li><a href="#" class="text-slate-400 hover:text-blue-400 transition-colors">Returns</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h4 class="text-lg font-bold text-white mb-4">Contact</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="<?= BASE_URL ?>/?page=contact" class="text-slate-400 hover:text-blue-400 transition-colors">Contact Us</a></li>
                        <li><a href="#" class="text-slate-400 hover:text-blue-400 transition-colors">Store Locator</a></li>
                        <li><span class="text-gray-300">Phone: (250) 782114520</span></li>
                        <li><span class="text-gray-300">Email: mutaganzwabright@gmail.com</span></li>
                    </ul>
                </div>

                <!-- Account -->
                <div>
                    <h4 class="text-lg font-bold text-white mb-4">Account</h4>
                    <ul class="space-y-2 text-sm">
                        <?php if ($store->isLoggedIn()): ?>
                            <li><a href="<?= BASE_URL ?>/?page=profile" class="text-slate-400 hover:text-blue-400 transition-colors">Profile</a></li>
                            <?php if ($store->isAdmin()): ?>
                                <li><a href="<?= BASE_URL ?>/admin/dashboard.php" class="text-slate-400 hover:text-blue-400 transition-colors">Admin</a></li>
                            <?php endif; ?>
                            <li><a href="<?= BASE_URL ?>/?page=logout" class="text-slate-400 hover:text-blue-400 transition-colors">Logout</a></li>
                        <?php else: ?>
                            <li><a href="<?= BASE_URL ?>/?page=login" class="text-slate-400 hover:text-blue-400 transition-colors">Login</a></li>
                            <li><a href="<?= BASE_URL ?>/?page=register" class="text-slate-400 hover:text-blue-400 transition-colors">Register</a></li>
                        <?php endif; ?>
                        <li><a href="<?= BASE_URL ?>/?page=cart" class="text-slate-400 hover:text-blue-400 transition-colors">Cart</a></li>
                    </ul>
                </div>

            </div>

            <!-- Bottom Bar -->
            <div class="border-t border-slate-700 mt-8 pt-6 text-center text-slate-400 text-sm">
                &copy; <?= date('Y') ?> <i class="fas fa-crown text-yellow-400"></i> <span class="text-white">Elite</span><span class="text-blue-400">Wear</span>. All rights reserved. | Privacy Policy | Terms of Service
            </div>
        </div>
    </footer>

</body>
</html>
