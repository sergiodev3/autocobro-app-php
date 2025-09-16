<?php
require_once '../app/models/Product.php';
class ProductAdminController {
    public function index() {
        $product = new Product();
        $products = $product->getAll();
        require '../app/views/products/index.php';
    }
    public function create() {
        require '../app/views/products/create.php';
    }
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $barcode = trim($_POST['barcode'] ?? '');
            $name = trim($_POST['name'] ?? '');
            $price = floatval($_POST['price'] ?? 0);
            $image = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $filename = uniqid('prod_') . '.' . $ext;
                $targetDir = __DIR__ . '/../../public/images/';
                $targetFile = $targetDir . $filename;
                if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                    $image = $filename; // Solo guarda el nombre del archivo
                }
            }
            $product = new Product();
            $product->create($barcode, $name, $price, $image);
            header('Location: index.php?url=ProductAdmin/index');
            exit;
        }
    }
    public function edit($id) {
        $product = new Product();
        $prod = $product->findById($id);
        require '../app/views/products/edit.php';
    }
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $barcode = trim($_POST['barcode'] ?? '');
            $name = trim($_POST['name'] ?? '');
            $price = floatval($_POST['price'] ?? 0);
            $image = $_POST['current_image'] ?? '';
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $filename = uniqid('prod_') . '.' . $ext;
                $targetDir = __DIR__ . '/../../public/images/';
                $targetFile = $targetDir . $filename;
                if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                    $image = $filename; // Solo guarda el nombre del archivo
                }
            }
            $product = new Product();
            $product->update($id, $barcode, $name, $price, $image);
            header('Location: index.php?url=ProductAdmin/index');
            exit;
        }
    }
    public function delete($id) {
        $product = new Product();
        $result = $product->delete($id);
        if ($result) {
            header('Location: index.php?url=ProductAdmin/index');
        } else {
            // Puedes mostrar un mensaje en la vista o redirigir con un parámetro de error
            header('Location: index.php?url=ProductAdmin/index&error=producto_no_eliminado');
        }
        exit;
    }
}
