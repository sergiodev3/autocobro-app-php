<?php
// Front Controller
require_once __DIR__ . '/../config/database.php';

// Mejor autoload con rutas absolutas
spl_autoload_register(function ($class) {
    $paths = [
        __DIR__ . '/../app/controllers/',
        __DIR__ . '/../app/models/'
    ];
    foreach ($paths as $path) {
        $file = $path . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// Routing
$url = isset($_GET['url']) ? explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL)) : [];
$controllerName = !empty($url[0]) ? ucfirst($url[0]) . 'Controller' : 'MainController';
$method = $url[1] ?? 'index';
$params = array_slice($url, 2);

error_log("URL: " . ($_GET['url'] ?? ''));
error_log("Controller: " . $controllerName);
error_log("Method: " . $method);

if (class_exists($controllerName)) {
    $controller = new $controllerName();
    if (method_exists($controller, $method)) {
        call_user_func_array([$controller, $method], $params);
        exit;
    } else {
        // Si es AJAX y el método no existe, responde JSON
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'error' => 'Método no encontrado']);
            exit;
        }
        // Mensaje de error para depuración
        echo "<h2>Error: El método <b>$method</b> no existe en el controlador <b>$controllerName</b>.</h2>";
        exit;
    }
} else {
    // Si es AJAX y el controlador no existe, responde JSON
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'error' => 'Controlador no encontrado']);
        exit;
    }
    // Mensaje de error para depuración
    echo "<h2>Error: El controlador <b>$controllerName</b> no existe.</h2>";
    exit;
}

// Default: show main view
require_once __DIR__ . '/../app/views/main.php';
