<?php
require_once '../app/models/Purchase.php';
class PurchaseController {
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            header('Content-Type: application/json');
            $userId = isset($_POST['user_id']) ? intval($_POST['user_id']) : null;
            $items = isset($_POST['items']) ? json_decode($_POST['items'], true) : [];
            $paymentType = isset($_POST['payment_type']) ? preg_replace('/[^a-zA-Z]/', '', $_POST['payment_type']) : '';
            // Validaciones básicas
            if (!$userId || !is_array($items) || count($items) === 0 || !in_array($paymentType, ['tarjeta', 'efectivo'])) {
                echo json_encode(['success' => false, 'error' => 'Datos de compra inválidos']);
                return;
            }
            $purchase = new Purchase();
            $result = $purchase->create($userId, $items, $paymentType);
            echo json_encode($result);
        }
    }
}
