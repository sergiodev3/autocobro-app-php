<?php
require_once __DIR__ . '/../../config/database.php';
class Product {
    private $conn;
    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }
    public function findByBarcode($barcode) {
        $stmt = $this->conn->prepare('SELECT * FROM products WHERE barcode = ?');
        $stmt->execute([$barcode]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAll() {
        $stmt = $this->conn->query('SELECT * FROM products ORDER BY id DESC');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($barcode, $name, $price, $imagePath) {
        $stmt = $this->conn->prepare('INSERT INTO products (barcode, name, price, image) VALUES (?, ?, ?, ?)');
        return $stmt->execute([$barcode, $name, $price, $imagePath]);
    }

    public function findById($id) {
        $stmt = $this->conn->prepare('SELECT * FROM products WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $barcode, $name, $price, $imagePath) {
        $stmt = $this->conn->prepare('UPDATE products SET barcode = ?, name = ?, price = ?, image = ? WHERE id = ?');
        return $stmt->execute([$barcode, $name, $price, $imagePath, $id]);
    }

    public function delete($id) {
        // Verifica si el producto tiene compras asociadas
        $stmt = $this->conn->prepare('SELECT COUNT(*) FROM purchase_items WHERE product_id = ?');
        $stmt->execute([$id]);
        $count = $stmt->fetchColumn();
        if ($count > 0) {
            // No eliminar, retorna falso o lanza una excepción
            return false;
        }
        // Si no tiene compras asociadas, elimina el producto
        $stmt = $this->conn->prepare('DELETE FROM products WHERE id = ?');
        return $stmt->execute([$id]);
    }
}
