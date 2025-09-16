<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Producto</title>
    <link rel="stylesheet" href="css/style.css"> <!-- Ruta corregida -->
</head>
<body>
    <div class="container">
        <h1>Agregar Producto</h1>
        <form action="index.php?url=ProductAdmin/store" method="POST" enctype="multipart/form-data">
            <label>Código de barras:<br><input type="text" name="barcode" required></label><br>
            <label>Nombre:<br><input type="text" name="name" required></label><br>
            <label>Precio:<br><input type="number" name="price" step="0.01" required></label><br>
            <label>Imagen:<br><input type="file" name="image" accept="image/*"></label><br><br>
            <div style="display:flex;gap:12px;justify-content:center;align-items:center;">
                <button type="submit" style="background:linear-gradient(90deg,#28a745 60%,#4ee07b 100%);color:#fff;font-weight:bold;box-shadow:0 2px 8px #b3c6e0;letter-spacing:1px;display:flex;align-items:center;gap:6px;">
                    <span style='font-size:1.2em;'>💾</span> Guardar
                </button>
                <a href="index.php?url=ProductAdmin/index" style="background:linear-gradient(90deg,#dc3545 60%,#ff7b7b 100%);color:#fff;font-weight:bold;box-shadow:0 2px 8px #b3c6e0;letter-spacing:1px;padding:0.6em 1.2em;border-radius:6px;text-decoration:none;display:flex;align-items:center;gap:6px;">
                    <span style='font-size:1.2em;'>✖️</span> Cancelar
                </a>
            </div>
        </form>
    </div>
</body>
</html>
