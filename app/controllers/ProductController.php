<?php
require_once '../app/models/Product.php';
class ProductController {
    public function getByBarcode() {
    header('Content-Type: application/json');
    $barcode = $_GET['barcode'] ?? '';
    $product = new Product();
    $data = $product->findByBarcode($barcode);
    echo json_encode($data);
    }
}
