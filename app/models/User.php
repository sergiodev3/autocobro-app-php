<?php
require_once __DIR__ . '/../../config/database.php';
class User {
    public function findByPhone($phone) {
        $stmt = $this->conn->prepare('SELECT * FROM users WHERE phone = ?');
        $stmt->execute([$phone]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    private $conn;
    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }
    public function register($phone) {
        // Evitar duplicados y SQL injection usando prepared statements
        $stmt = $this->conn->prepare('SELECT id FROM users WHERE phone = ?');
        $stmt->execute([$phone]);
        if ($stmt->fetch()) {
            return 'exists'; // Ya existe
        }
        $stmt = $this->conn->prepare('INSERT INTO users (phone, cashback) VALUES (?, 0)');
        if ($stmt->execute([$phone])) {
            return $this->conn->lastInsertId();
        }
        return false;
    }
}
