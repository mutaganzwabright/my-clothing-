<?php
require_once 'config.php';
class Database {
private static $instance = null;
private $conn;
private function __construct() {
try {
$this->conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($this->conn->connect_error) {
throw new mysqli_sql_exception('Connection Error: ' . $this->conn->connect_error);
}
$this->conn->set_charset('utf8mb4');
} catch (mysqli_sql_exception $e) {
error_log('Database Connection Error: ' . $e->getMessage());
die('Database connection failed. Please contact the administrator.');
}
}
public static function getInstance() {
if (self::$instance === null) {
self::$instance = new Database();
}
return self::$instance;
}
public function getConnection() {
return $this->conn;
}
}
$db = Database::getInstance()->getConnection();