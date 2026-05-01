<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/database.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/navigation.php';

//
// admin/dashboard.php
//

// Ensure user is admin
if (!$store->isLoggedIn()) {
    header('Location: ' . BASE_URL . '/?page=login');
    exit;
}
if (!$store->isAdmin()) {
    die('Access denied. You must be an administrator to access this page.');
}

// Get metrics
$users = $db->query("SELECT COUNT(*) total FROM users")->fetch_assoc()['total'];
$orders = $db->query("SELECT COUNT(*) total FROM orders")->fetch_assoc()['total'];
$revenue = $db->query("SELECT SUM(total) sum FROM orders WHERE status != 'pending'")->fetch_assoc()['sum'] ?? 0;
$pendingOrders = $db->query("SELECT COUNT(*) total FROM orders WHERE status = 'pending'")->fetch_assoc()['total'];

// Get recent orders
$recentOrders = $db->query("
    SELECT o.id, o.total, o.status, o.created_at, u.username
    FROM orders o
    JOIN users u ON o.user_id = u.id
    ORDER BY o.created_at DESC
    LIMIT 5
");

// Get monthly revenue for chart
$monthlyRevenue = $db->query("
    SELECT DATE_FORMAT(created_at, '%Y-%m') as month, SUM(total) as revenue
    FROM orders
    WHERE status != 'pending' AND created_at >= DATE_SUB(NOW(), INTERVAL 12 MONTH)
    GROUP BY DATE_FORMAT(created_at, '%Y-%m')
    ORDER BY month
");

// Get order status counts for pie chart
$orderStatuses = $db->query("
    SELECT status, COUNT(*) as count
    FROM orders
    GROUP BY status
");

?>

<?php
?>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="min-h-screen bg-slate-50">
    <div class="container mx-auto px-4 py-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-slate-900">Admin Dashboard</h1>
            <p class="text-slate-600 mt-2">Welcome back! Here's an overview of your store.</p>
        </div>

        <!-- Metrics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-slate-600">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-slate-100 text-slate-600">
                        <i class="fas fa-users text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-slate-600">Total Users</p>
                        <p class="text-2xl font-bold text-slate-900"><?php echo number_format($users); ?></p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-emerald-500">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-emerald-100 text-emerald-600">
                        <i class="fas fa-shopping-cart text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-slate-600">Total Orders</p>
                        <p class="text-2xl font-bold text-slate-900"><?php echo number_format($orders); ?></p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-amber-500">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-amber-100 text-amber-600">
                        <i class="fas fa-dollar-sign text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-slate-600">Total Revenue</p>
                        <p class="text-2xl font-bold text-slate-900">$<?php echo number_format($revenue, 2); ?></p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-red-500">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-red-100 text-red-600">
                        <i class="fas fa-clock text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-slate-600">Pending Orders</p>
                        <p class="text-2xl font-bold text-slate-900"><?php echo number_format($pendingOrders); ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Revenue Chart -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-slate-900 mb-4">Monthly Revenue</h3>
                <canvas id="revenueChart" width="400" height="200"></canvas>
            </div>

            <!-- Order Status Chart -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-slate-900 mb-4">Order Status Distribution</h3>
                <canvas id="statusChart" width="400" height="200"></canvas>
            </div>
        </div>

        <!-- Recent Orders -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-slate-900">Recent Orders</h3>
                <a href="orders.php" class="text-amber-600 hover:text-amber-800 font-medium">View All</a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full table-auto">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-slate-500 uppercase">Order ID</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-slate-500 uppercase">Customer</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-slate-500 uppercase">Total</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-slate-500 uppercase">Status</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-slate-500 uppercase">Date</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-200">
                        <?php while ($order = $recentOrders->fetch_assoc()): ?>
                        <tr>
                            <td class="px-4 py-2 whitespace-nowrap text-sm font-medium text-slate-900">#<?php echo $order['id']; ?></td>
                            <td class="px-4 py-2 whitespace-nowrap text-sm text-slate-500"><?php echo htmlspecialchars($order['username']); ?></td>
                            <td class="px-4 py-2 whitespace-nowrap text-sm text-slate-500">$<?php echo number_format($order['total'], 2); ?></td>
                            <td class="px-4 py-2 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    <?php
                                    switch($order['status']) {
                                        case 'pending': echo 'bg-slate-100 text-slate-800'; break;
                                        case 'paid': echo 'bg-emerald-100 text-emerald-800'; break;
                                        case 'shipped': echo 'bg-amber-100 text-amber-800'; break;
                                        case 'delivered': echo 'bg-emerald-100 text-emerald-800'; break;
                                        default: echo 'bg-slate-100 text-slate-800';
                                    }
                                    ?>">
                                    <?php echo ucfirst($order['status']); ?>
                                </span>
                            </td>
                            <td class="px-4 py-2 whitespace-nowrap text-sm text-slate-500"><?php echo date('M d, Y', strtotime($order['created_at'])); ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-slate-900 mb-4">Quick Actions</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="products.php" class="flex items-center p-4 bg-slate-50 rounded-lg hover:bg-slate-100 transition-colors border-l-4 border-slate-600">
                    <i class="fas fa-box text-slate-600 text-2xl mr-3"></i>
                    <div>
                        <p class="font-medium text-slate-900">Manage Products</p>
                        <p class="text-sm text-slate-600">Add, edit, or remove products</p>
                    </div>
                </a>
                <a href="orders.php" class="flex items-center p-4 bg-slate-50 rounded-lg hover:bg-slate-100 transition-colors border-l-4 border-emerald-500">
                    <i class="fas fa-shopping-bag text-emerald-600 text-2xl mr-3"></i>
                    <div>
                        <p class="font-medium text-slate-900">Manage Orders</p>
                        <p class="text-sm text-slate-600">View and update order status</p>
                    </div>
                </a>
                <a href="users.php" class="flex items-center p-4 bg-slate-50 rounded-lg hover:bg-slate-100 transition-colors border-l-4 border-amber-500">
                    <i class="fas fa-users text-amber-600 text-2xl mr-3"></i>
                    <div>
                        <p class="font-medium text-slate-900">User Management</p>
                        <p class="text-sm text-slate-600">Manage user accounts</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<script>
// Revenue Chart
const revenueCtx = document.getElementById('revenueChart').getContext('2d');
const revenueData = {
    labels: [<?php
        $labels = [];
        $data = [];
        while ($row = $monthlyRevenue->fetch_assoc()) {
            $labels[] = "'" . date('M Y', strtotime($row['month'] . '-01')) . "'";
            $data[] = $row['revenue'];
        }
        echo implode(',', $labels);
    ?>],
    datasets: [{
        label: 'Revenue',
        data: [<?php echo implode(',', $data); ?>],
        borderColor: 'rgb(59, 130, 246)',
        backgroundColor: 'rgba(59, 130, 246, 0.1)',
        tension: 0.1
    }]
};
new Chart(revenueCtx, {
    type: 'line',
    data: revenueData,
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return '$' + value.toLocaleString();
                    }
                }
            }
        }
    }
});

// Order Status Chart
const statusCtx = document.getElementById('statusChart').getContext('2d');
const statusData = {
    labels: [<?php
        $statusLabels = [];
        $statusCounts = [];
        while ($row = $orderStatuses->fetch_assoc()) {
            $statusLabels[] = "'" . ucfirst($row['status']) . "'";
            $statusCounts[] = $row['count'];
        }
        echo implode(',', $statusLabels);
    ?>],
    datasets: [{
        data: [<?php echo implode(',', $statusCounts); ?>],
        backgroundColor: [
            'rgb(148, 163, 184)', // slate for pending
            'rgb(16, 185, 129)',  // emerald for paid
            'rgb(245, 158, 11)',  // amber for shipped
            'rgb(16, 185, 129)'   // emerald for delivered
        ]
    }]
};
new Chart(statusCtx, {
    type: 'pie',
    data: statusData,
    options: {
        responsive: true
    }
});
</script>

<?php require_once '../includes/footer.php'; ?>
