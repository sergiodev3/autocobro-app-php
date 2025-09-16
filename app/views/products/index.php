<?php
// Si la petición es AJAX, responde JSON
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}
$error = isset($_GET['error']) ? $_GET['error'] : '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Administrar Productos</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <?php if ($error === 'producto_no_eliminado'): ?>
            <div id="error-aviso" style="background:#ffe0e0;color:#a94442;padding:1em;border-radius:6px;margin-bottom:1em;border:1px solid #f5c6cb;position:relative;">
                <b>No se puede eliminar el producto.</b> Este producto ya ha sido comprado y está registrado en el historial de compras.
                <button onclick="document.getElementById('error-aviso').style.display='none';" style="position:absolute;top:8px;right:12px;background:#a94442;color:#fff;border:none;border-radius:3px;padding:2px 8px;cursor:pointer;font-size:1em;">✖</button>
            </div>
            <script>
                setTimeout(function() {
                    var aviso = document.getElementById('error-aviso');
                    if (aviso) aviso.style.display = 'none';
                }, 5000);
            </script>
        <?php endif; ?>
        <h1 style="margin-bottom:0.5em;">Productos</h1>
        <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:10px;">
            <a href="index.php?url=ProductAdmin/create" style="background:#007bff;color:#fff;padding:0.5em 1em;border-radius:5px;text-decoration:none;">Agregar producto</a>
            <input type="text" id="search-product" placeholder="Buscar por nombre o código..." style="flex:1;max-width:220px;padding:0.5em 0.7em;border-radius:6px;border:1px solid #b3c6e0;">
        </div>
        <div style="max-height:420px;overflow-y:auto;border-radius:8px;box-shadow:0 2px 8px #b3c6e0;margin-top:1em;">
            <table id="products-table" style="width:100%;background:#f8fbff;table-layout:fixed;">
                <thead style="background:#e0eaff;position:sticky;top:0;z-index:2;">
                    <tr>
                        <th>ID</th>
                        <th>Imagen</th>
                        <th>Nombre</th>
                        <th>Código de barras</th>
                        <th>Precio</th>
                        <th style="width:150px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $p): ?>
                    <tr>
                        <td><?= $p['id'] ?></td>
                        <td>
                            <?php if ($p['image']): ?>
                                <img src="images/<?= $p['image'] ?>" style="height:40px;max-width:60px;object-fit:contain;box-shadow:0 2px 8px #b3c6e0;border-radius:5px;"/>
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($p['name']) ?></td>
                        <td><?= htmlspecialchars($p['barcode']) ?></td>
                        <td>$<?= number_format($p['price'],2) ?></td>
                        <td style="display:flex;gap:8px;justify-content:center;align-items:center;flex-wrap:wrap;">
                            <a href="index.php?url=ProductAdmin/edit/<?= $p['id'] ?>" title="Editar" style="background:linear-gradient(90deg,#007bff 60%,#4e8cff 100%);color:#fff;font-weight:bold;box-shadow:0 2px 8px #b3c6e0;letter-spacing:1px;padding:0.4em 0.9em;border-radius:6px;text-decoration:none;display:flex;align-items:center;gap:5px;">
                                <span style='font-size:1.1em;'>✏️</span> Editar
                            </a>
                            <a href="index.php?url=ProductAdmin/delete/<?= $p['id'] ?>" title="Eliminar" style="background:linear-gradient(90deg,#dc3545 60%,#ff7b7b 100%);color:#fff;font-weight:bold;box-shadow:0 2px 8px #b3c6e0;letter-spacing:1px;padding:0.4em 0.9em;border-radius:6px;text-decoration:none;display:flex;align-items:center;gap:5px;" onclick="return confirm('¿Eliminar producto?')">
                                <span style='font-size:1.1em;'>🗑️</span> Eliminar
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <a href="index.php" style="display:inline-block;margin-top:1.5em;background:#2a4d8f;color:#fff;padding:0.5em 1.2em;border-radius:6px;text-decoration:none;">Regresar al inicio</a>
        <script>
        document.getElementById('search-product').addEventListener('input', function() {
            const value = this.value.toLowerCase();
            const rows = document.querySelectorAll('#products-table tbody tr');
            rows.forEach(row => {
                const name = row.children[2].innerText.toLowerCase();
                const barcode = row.children[3].innerText.toLowerCase();
                if (name.includes(value) || barcode.includes(value)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
        </script>
    </div>
</body>
</html>
