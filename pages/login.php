<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if (empty($email) || empty($password)) {
        $error = 'Email and password are required';
    } elseif ($store->login($email, $password)) {
        // Redirect admins to the admin dashboard
        if ($store->isAdmin()) {
            header('Location: admin/dashboard.php');
            exit;
        }
        header('Location: ?page=home');
        exit;
    } else {
        $error = 'Invalid credentials';
    }
}

?>

<div class="container mx-auto px-4 py-8">
    <div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-6 border border-slate-200">
        <h2 class="text-2xl font-bold mb-6 text-center text-slate-900">Login</h2>
        <?php if (isset($error)): ?>
            <p class="text-red-600 mb-4 text-center bg-red-50 p-3 rounded-md border border-red-200"><?= $error ?></p>
        <?php endif; ?>
        <form method="post" class="space-y-4">
            <div>
                <label for="email" class="block text-sm font-medium text-slate-700">Email</label>
                <input type="email" id="email" name="email" required class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-md shadow-sm focus:outline-none focus:ring-amber-500 focus:border-amber-500 bg-slate-50">
            </div>
            <div>
                <label for="password" class="block text-sm font-medium text-slate-700">Password</label>
                <input type="password" id="password" name="password" required class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-md shadow-sm focus:outline-none focus:ring-amber-500 focus:border-amber-500 bg-slate-50">
            </div>
            <button type="submit" class="w-full bg-amber-600 text-white py-2 px-4 rounded-md hover:bg-amber-700 transition-all duration-300 shadow-lg hover:shadow-xl">Login</button>
        </form>
        <p class="mt-4 text-center"><a href="?page=register" class="text-amber-600 hover:text-amber-800 font-medium">Register</a></p>
    </div>
</div>