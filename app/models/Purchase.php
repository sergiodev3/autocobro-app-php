<?php
require_once __DIR__ . '/../../config/database.php';
class Purchase {
    private $conn;
    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }
    public function create($userId, $items, $paymentType) {
        $this->conn->beginTransaction();
        try {
            $total = 0;
            foreach ($items as $item) {
                $total += $item['price'] * $item['quantity'];
            }
            $cashback = round($total * 0.05, 2); // 5% cashback
            $stmt = $this->conn->prepare('INSERT INTO purchases (user_id, total, payment_type, cashback) VALUES (?, ?, ?, ?)');
            $stmt->execute([$userId, $total, $paymentType, $cashback]);
            $purchaseId = $this->conn->lastInsertId();
            foreach ($items as $item) {
                $stmt = $this->conn->prepare('INSERT INTO purchase_items (purchase_id, product_id, quantity, price) VALUES (?, ?, ?, ?)');
                $stmt->execute([$purchaseId, $item['id'], $item['quantity'], $item['price']]);
            }
            $stmt = $this->conn->prepare('UPDATE users SET cashback = cashback + ? WHERE id = ?');
            $stmt->execute([$cashback, $userId]);
            $this->conn->commit();
            return ['success' => true, 'purchase_id' => $purchaseId, 'cashback' => $cashback];
        } catch (Exception $e) {
            $this->conn->rollBack();
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
}
