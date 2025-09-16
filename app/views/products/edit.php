<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Producto</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>Editar Producto</h1>
        <form action="index.php?url=ProductAdmin/update/<?= $prod['id'] ?>" method="POST" enctype="multipart/form-data">
            <label>Código de barras:<br><input type="text" name="barcode" value="<?= htmlspecialchars($prod['barcode']) ?>" required></label><br>
            <label>Nombre:<br><input type="text" name="name" value="<?= htmlspecialchars($prod['name']) ?>" required></label><br>
            <label>Precio:<br><input type="number" name="price" step="0.01" value="<?= $prod['price'] ?>" required></label><br>
            <label>Imagen actual:<br><?php if ($prod['image']): ?><img src="../../public/images/<?= $prod['image'] ?>" style="height:60px;max-width:100px;object-fit:contain;box-shadow:0 2px 8px #b3c6e0;border-radius:5px;"/><?php endif; ?></label><br>
            <input type="hidden" name="current_image" value="<?= htmlspecialchars($prod['image']) ?>">
            <label>Cambiar imagen:<br><input type="file" name="image" accept="image/*"></label><br><br>
            <div style="display:flex;gap:12px;justify-content:center;align-items:center;">
                <button type="submit" style="background:linear-gradient(90deg,#28a745 60%,#4ee07b 100%);color:#fff;font-weight:bold;box-shadow:0 2px 8px #b3c6e0;letter-spacing:1px;display:flex;align-items:center;gap:6px;">
                    <span style='font-size:1.2em;'>✏️</span> Actualizar
                </button>
                <a href="index.php?url=ProductAdmin/index" style="background:linear-gradient(90deg,#dc3545 60%,#ff7b7b 100%);color:#fff;font-weight:bold;box-shadow:0 2px 8px #b3c6e0;letter-spacing:1px;padding:0.6em 1.2em;border-radius:6px;text-decoration:none;display:flex;align-items:center;gap:6px;">
                    <span style='font-size:1.2em;'>✖️</span> Cancelar
                </a>
            </div>
        </form>
    </div>
</body>
</html>
