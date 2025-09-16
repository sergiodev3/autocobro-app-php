<?php
require_once '../app/models/User.php';
class UserController {
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            header('Content-Type: application/json');
            $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
            if (empty($phone) || !preg_match('/^[0-9]{8,15}$/', $phone)) {
                echo json_encode(['success' => false, 'error' => 'Número de teléfono inválido']);
                return;
            }
            $user = new User();
            $data = $user->findByPhone($phone);
            if ($data) {
                echo json_encode(['success' => true, 'user_id' => $data['id'], 'cashback' => $data['cashback']]);
            } else {
                echo json_encode(['success' => false, 'error' => 'Usuario no encontrado']);
            }
        }
    }
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            header('Content-Type: application/json');
            $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
            // Validación básica: no vacío, solo números, longitud razonable
            if (empty($phone) || !preg_match('/^[0-9]{8,15}$/', $phone)) {
                echo json_encode(['success' => false, 'error' => 'Número de teléfono inválido']);
                return;
            }
            $user = new User();
            $userId = $user->register($phone);
            if ($userId === 'exists') {
                echo json_encode(['success' => false, 'error' => 'Ya existe una cuenta con ese número.']);
            } else {
                echo json_encode(['success' => $userId ? true : false, 'user_id' => $userId]);
            }
        }
    }

    public function logout() {
        // Si usas sesiones, destrúyelas aquí
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_unset();
        session_destroy();
        // Redirige al inicio
        header('Location: index.php');
        exit;
    }
}
