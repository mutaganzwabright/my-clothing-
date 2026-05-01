<?php
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $msg = trim($_POST['message'] ?? '');
    
    if (empty($name) || empty($email) || empty($msg)) {
        $message = '<p class="text-red-600 mb-4 text-center bg-red-50 p-3 rounded-md border border-red-200">All fields are required</p>';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = '<p class="text-red-600 mb-4 text-center bg-red-50 p-3 rounded-md border border-red-200">Invalid email address</p>';
    } else {
        // In a real application, send email or store in database
        error_log("Contact form: Name: $name, Email: $email, Message: " . substr($msg, 0, 100));
        $message = '<p class="text-green-600 mb-4 text-center bg-green-50 p-3 rounded-md border border-green-200">Thank you for your message! We will get back to you soon.</p>';
    }
}
?>

<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-4xl font-bold mb-6 text-center text-slate-900">Contact Us</h1>
        <div class="bg-white rounded-lg shadow-md p-6 border border-slate-200">
            <?php echo $message; ?>
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
                    <label for="message" class="block text-sm font-medium text-slate-700">Message</label>
                    <textarea id="message" name="message" rows="4" required class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-md shadow-sm focus:outline-none focus:ring-amber-500 focus:border-amber-500 bg-slate-50"></textarea>
                </div>
                <button type="submit" class="w-full bg-amber-600 text-white py-2 px-4 rounded-md hover:bg-amber-700 transition-all duration-300 shadow-lg hover:shadow-xl">Send Message</button>
            </form>
        </div>
    </div>
</div>