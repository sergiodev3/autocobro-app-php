let userId = null;
let cart = [];



function registerUser() {
    const phone = document.getElementById('phone').value;
    fetch('index.php?url=User/register', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'phone=' + encodeURIComponent(phone)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            userId = data.user_id;
            Swal.fire({
                icon: 'success',
                title: '¡Registro exitoso!',
                text: 'Bienvenido, tu cuenta ha sido creada.',
                timer: 1500,
                showConfirmButton: false
            });
            showWelcome(phone, 0);
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error al registrar',
                text: data.error || 'Verifica el número ingresado.',
                confirmButtonColor: '#2a4d8f'
            });
        }
    });
}


function loginUser() {
    const phone = document.getElementById('login-phone').value;
    fetch('index.php?url=User/login', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'phone=' + encodeURIComponent(phone)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            userId = data.user_id;
            Swal.fire({
                icon: 'success',
                title: '¡Bienvenido de nuevo!',
                text: 'Tu cashback acumulado: $' + parseFloat(data.cashback).toFixed(2),
                timer: 1500,
                showConfirmButton: false
            });
            showWelcome(phone, data.cashback);
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error al iniciar sesión',
                text: data.error || 'Verifica el número ingresado.',
                confirmButtonColor: '#2a4d8f'
            });
        }
    });
}

function showWelcome(phone, cashback) {
    document.getElementById('user-section').style.display = 'none';
    document.getElementById('welcome-section').style.display = '';
    document.getElementById('scan-section').style.display = '';
    document.getElementById('barcode').focus();
    document.getElementById('welcome-msg').innerText = '¡Bienvenido, ' + phone + '!';
    document.getElementById('cashback-msg').innerText = 'Cashback acumulado: $' + parseFloat(cashback).toFixed(2);
}

function scanProduct() {
    const barcode = document.getElementById('barcode').value;
    fetch('index.php?url=Product/getByBarcode&barcode=' + encodeURIComponent(barcode))
    .then(res => res.json())
    .then(product => {
        if (product && product.id) {
            let found = cart.find(item => item.id === product.id);
            if (found) {
                found.quantity++;
            } else {
                cart.push({ ...product, quantity: 1 });
            }
            renderCart();
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: 'Producto agregado',
                showConfirmButton: false,
                timer: 1200
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Producto no encontrado',
                text: 'Verifica el código de barras',
                confirmButtonColor: '#2a4d8f'
            });
        }
        document.getElementById('barcode').value = '';
        document.getElementById('barcode').focus();
    });
}




function renderCart() {
    const tbody = document.getElementById('cart');
    tbody.innerHTML = '';
    let total = 0;
    cart.forEach((item, idx) => {
        total += item.price * item.quantity;
        // Extrae solo el nombre del archivo de la ruta
        let imageFile = item.image;
        if (imageFile && imageFile.includes('/')) {
            imageFile = imageFile.split('/').pop();
        }
        tbody.innerHTML += `<tr>`
            + `<td style='text-align:center;'>${imageFile ? `<img src='images/${imageFile}' style='height:70px;width:70px;object-fit:contain;border-radius:8px;border:1px solid #ccc;display:block;margin:auto;'>` : ''}</td>`
            + `<td style='text-align:center;'>${item.name}</td>`
            + `<td style='min-width:110px;text-align:center;'>`
                + `<button onclick='decreaseQty(${idx})' title='Quitar uno' style='background:#ffc107;color:#222;border:none;padding:0.2em 0.6em;border-radius:4px;cursor:pointer;font-weight:bold;width:32px;'>-</button>`
                + `<span style='margin:0 8px;font-weight:bold;display:inline-block;width:32px;text-align:center;'>${item.quantity}</span>`
                + `<button onclick='increaseQty(${idx})' title='Agregar uno' style='background:#28a745;color:#fff;border:none;padding:0.2em 0.6em;border-radius:4px;cursor:pointer;font-weight:bold;width:32px;'>+</button>`
            + `</td>`
            + `<td style='text-align:center;'>$${(item.price * item.quantity).toFixed(2)}</td>`
            + `<td style='text-align:center;'><button onclick='removeFromCart(${idx})' title='Eliminar producto' style='background:#dc3545;color:#fff;border:none;padding:0.2em 0.6em;border-radius:4px;cursor:pointer;font-weight:bold;width:32px;'>🗑️</button></td>`
        + `</tr>`;
    });
    document.getElementById('total').innerText = 'Total: $' + total.toFixed(2);
    if (cart.length > 0) {
        document.getElementById('payment-section').style.display = '';
    } else {
        document.getElementById('payment-section').style.display = 'none';
    }
}

function removeFromCart(idx) {
    cart.splice(idx, 1);
    renderCart();
}

function increaseQty(idx) {
    cart[idx].quantity++;
    renderCart();
}

function decreaseQty(idx) {
    cart[idx].quantity--;
    if (cart[idx].quantity <= 0) {
        cart.splice(idx, 1);
    }
    renderCart();
}

function finishPurchase() {
    const paymentType = document.getElementById('payment-type').value;
    fetch('index.php?url=Purchase/create', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'user_id=' + encodeURIComponent(userId) + '&payment_type=' + encodeURIComponent(paymentType) + '&items=' + encodeURIComponent(JSON.stringify(cart))
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            showTicket(data.purchase_id, paymentType, data.cashback);
            Swal.fire({
                icon: 'success',
                title: '¡Compra realizada!',
                showConfirmButton: false,
                timer: 1500
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error al finalizar compra',
                text: data.error || '',
                confirmButtonColor: '#2a4d8f'
            });
        }
    });
}


function showTicket(purchaseId, paymentType, cashback) {
    let html = '<h2>Ticket</h2>';
    html += `<p style='margin-bottom:0.5em;'>Cliente: <b>${userId}</b></p>`;
    html += '<ul>';
    let total = 0;
    cart.forEach(item => {
        html += `<li>${item.name} x${item.quantity} - $${(item.price * item.quantity).toFixed(2)}</li>`;
        total += item.price * item.quantity;
    });
    html += '</ul>';
    html += `<p>Total: $${total.toFixed(2)}</p>`;
    html += `<p>Pago: ${paymentType}</p>`;
    html += `<p>Cashback ganado: $${cashback}</p>`;
    html += `<p>Compra #${purchaseId}</p>`;
    html += '<button id="print-btn">Imprimir ticket</button>';
    document.getElementById('ticket-section').innerHTML = html;
    document.getElementById('ticket-section').style.display = '';
    document.getElementById('scan-section').style.display = 'none';
    document.getElementById('print-btn').onclick = function() {
        window.print();
        setTimeout(() => {
            location.reload();
        }, 500);
    };
}

function logoutUser() {
    fetch('index.php?url=User/logout')
        .then(() => {
            userId = null;
            location.reload();
        });
}
