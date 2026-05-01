<?php

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/database.php';
require_once __DIR__ . '/includes/functions.php';

// Start output buffering so page redirects work after includes
ob_start();

// Handle page routing
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

// Define allowed pages
$allowed_pages = [
    'home', 'shop', 'product_detail', 'category', 'cart', 
    'checkout', 'login', 'register', 'logout', 
    'profile', 'orders', 'wishlist', 'contact', 'about'
];

if (!in_array($page, $allowed_pages)) {
    $page = 'home';
}

// Handle logout
if ($page == 'logout') {
    session_destroy();
    header('Location: ?page=home');
    exit;
}

// Include header
require_once __DIR__ . '/includes/header.php';

// Include navigation
require_once __DIR__ . '/includes/navigation.php';

// Include page content
$page_file = __DIR__ . '/pages/' . $page . '.php';
if (file_exists($page_file)) {
    include $page_file;
} else {
    include __DIR__ . '/pages/home.php';
}

// Include footer
require_once __DIR__ . '/includes/footer.php';

// Flush any buffered output after headers are set
ob_end_flush();
?>

