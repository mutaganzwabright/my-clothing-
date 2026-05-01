<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $adminCode = trim($_POST['admin_code'] ?? '');
    
    // Validate inputs
    if (empty($name) || empty($email) || empty($password)) {
        $error = 'All fields are required';
    } elseif (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Invalid email address';
    } else {
        $role = 'user';
        if (!empty($adminCode) && defined('ADMIN_REG_CODE') && hash_equals(ADMIN_REG_CODE, $adminCode)) {
            $role = 'admin';
        }

        if ($store->register($name, $email, $password, $name, $role)) {
            header('Location: ?page=login');
            exit;
        } else {
            if ($store->userExists($name, $email)) {
                $error = 'That username or email is already registered.';
            } else {
                $error = 'Registration failed. Please try again.';
            }
        }
    }
        }
    }
}

?>

<div class="container mx-auto px-4 py-8">
    <div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-6 border border-slate-200">
        <h2 class="text-2xl font-bold mb-6 text-center text-slate-900">Register</h2>
        <?php if (isset($error)): ?>
            <p class="text-red-600 mb-4 text-center bg-red-50 p-3 rounded-md border border-red-200"><?= $error ?></p>
        <?php endif; ?>
        <form method="post" class="space-y-4">
            <div>
                <label for="name" class="block text-sm font-medium text-slate-700">Name</label>
                <input type="text" id="name" name="name" required class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-md shadow-sm focus:outline-none focus:ring-amber-500 focus:border-amber-500 bg-slate-50">
            </div>
            <div>
                <label for="email" class="block text-sm font-medium text-slate-700">Email</label>
                <input type="email" id="email" name="email" required class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-md shadow-sm focus:outline-none focus:ring-amber-500 focus:border-amber-500 bg-slate-50">
            </div>
            <div>
                <label for="password" class="block text-sm font-medium text-slate-700">Password</label>
                <input type="password" id="password" name="password" required class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-md shadow-sm focus:outline-none focus:ring-amber-500 focus:border-amber-500 bg-slate-50">
            </div>
            <div>
                <label for="admin_code" class="block text-sm font-medium text-slate-700">Admin Code (optional)</label>
                <input type="text" id="admin_code" name="admin_code" placeholder="Enter admin code to register as admin" class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-md shadow-sm focus:outline-none focus:ring-amber-500 focus:border-amber-500 bg-slate-50">
            </div>
            <button type="submit" class="w-full bg-amber-600 text-white py-2 px-4 rounded-md hover:bg-amber-700 transition-all duration-300 shadow-lg hover:shadow-xl">Register</button>
        </form>
        <p class="mt-4 text-center"><a href="?page=login" class="text-amber-600 hover:text-amber-800 font-medium">Login</a></p>
    </div>
</div>