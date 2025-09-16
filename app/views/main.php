<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autocobro</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="js/app.js"></script>
</head>
<body>
    <div class="container">
        <div style="text-align:right; margin-bottom:1em;">
            <a href="index.php?url=ProductAdmin/index" class="btn">Panel de productos</a>
            <a href="index.php?url=User/logout" class="btn">Salir</a>
        </div>
        <h1>Autocobro</h1>
        <div id="user-section">
            <h2>Registro de usuario</h2>
            <input type="tel" id="phone" placeholder="Número de teléfono">
            <button onclick="registerUser()">Registrar</button>
            <div id="user-info"></div>
            <hr style="margin:1.5em 0;">
            <h2>¿Ya estas registrado?</h2>
            <input type="tel" id="login-phone" placeholder="Número de teléfono">
            <button onclick="loginUser()">Iniciar</button>
            <div id="login-info"></div>
        </div>
        <div id="welcome-section" style="display:none;">
            <h2 id="welcome-msg"></h2>
            <div id="cashback-msg"></div>
        </div>
        <div id="scan-section" style="display:none;">
            <h2>Escanea tus productos</h2>
            <input type="text" id="barcode" placeholder="Escanea código de barras" autofocus>
            <div class="center-btns">
                <button onclick="scanProduct()">Agregar</button>
            </div>
            <div style="max-height:260px;overflow-y:auto;border-radius:8px;box-shadow:0 2px 8px #b3c6e0;margin:0.7em 0 0.5em 0;">
                <table id="cart-table" style="width:100%;background:#f8fbff;table-layout:fixed;">
                    <thead style="background:#e0eaff;position:sticky;top:0;z-index:2;">
                        <tr>
                            <th>Imagen</th>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Total</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="cart">
                        <!-- El carrito se llena dinámicamente con JS, no pongas filas de ejemplo aquí -->
                    </tbody>
                </table>
            </div>
            <div id="total"></div>
            <div id="payment-section" style="display:none;">
                <h3>Selecciona tipo de pago</h3>
                <select id="payment-type">
                    <option value="tarjeta">Tarjeta</option>
                    <option value="efectivo">Efectivo</option>
                </select>
                <div class="center-btns">
                    <button onclick="finishPurchase()">Finalizar compra</button>
                </div>
            </div>
        </div>
        <div id="ticket-section" style="display:none;"></div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <script src="js/app.js"></script>
</body>
</html>
