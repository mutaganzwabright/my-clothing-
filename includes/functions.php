<?php
require_once __DIR__ . '/database.php';

class Store {

    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    /* ========== AUTH ========== */

    public function register($username, $email, $password, $fullName, $role = 'user') {
        if ($this->userExists($username, $email)) {
            return false;
        }

        $hash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->db->prepare(
            "INSERT INTO users (username, email, password, full_name, role) VALUES (?, ?, ?, ?, ?)"
        );
        $stmt->bind_param('sssss', $username, $email, $hash, $fullName, $role);

        try {
            return $stmt->execute();
        } catch (mysqli_sql_exception $e) {
            return false;
        }
    }

    public function userExists($username, $email) {
        $stmt = $this->db->prepare(
            "SELECT id FROM users WHERE username = ? OR email = ? LIMIT 1"
        );
        $stmt->bind_param('ss', $username, $email);
        $stmt->execute();
        return (bool) $stmt->get_result()->fetch_assoc();
    }

    public function login($identifier, $password) {
        $stmt = $this->db->prepare(
            "SELECT * FROM users WHERE username = ? OR email = ? LIMIT 1"
        );
        $stmt->bind_param('ss', $identifier, $identifier);
        $stmt->execute();

        $result = $stmt->get_result();
        if ($user = $result->fetch_assoc()) {
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = $user['role'];
                return true;
            }
        }
        return false;
    }

    public function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }

    public function isAdmin() {
        return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
    }

    /* ========== PRODUCTS ========== */

    // Added optional limit parameter (null means no limit)
    public function getProducts($search = '', $limit = null) {
        if ($search) {
            $sql = "SELECT * FROM products WHERE name LIKE ? OR description LIKE ? ORDER BY created_at DESC";
            if ($limit && is_int($limit)) {
                $sql .= " LIMIT ?";
            }
            $stmt = $this->db->prepare($sql);
            $searchTerm = '%' . $search . '%';
            if ($limit && is_int($limit)) {
                $stmt->bind_param('ssi', $searchTerm, $searchTerm, $limit);
            } else {
                $stmt->bind_param('ss', $searchTerm, $searchTerm);
            }
            $stmt->execute();
            return $stmt->get_result();
        } else {
            $sql = "SELECT * FROM products ORDER BY created_at DESC";
            if ($limit && is_int($limit)) {
                $sql .= " LIMIT " . intval($limit);
            }
            return $this->db->query($sql);
        }
    }

    public function getProduct($id) {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    /* ========== CART ========== */

    public function addToCart($productId, $qty = 1) {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        $_SESSION['cart'][$productId] =
            ($_SESSION['cart'][$productId] ?? 0) + $qty;
    }

    public function getCartItems() {
        return $_SESSION['cart'] ?? [];
    }
}

// Initialize store
$store = new Store($db);

// Initialize empty cart if not set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}
