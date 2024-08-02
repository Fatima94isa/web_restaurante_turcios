<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./img/Logo.jpg" type="image/jpg" size="16x16">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="stylees.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.6.0/jspdf.umd.min.js"></script>
    <title>Pedidos-Factura</title>
</head>
<body>
<header>
        <nav class="navbar">
            <div class="logo">
                <img src="./img/Logo22.png" alt="Logo">
                <span>Juancho's Restaurant</span>
            </div>
            <ul class="menu">
                <li><a href="index.html"><i class="fas fa-home"></i> Inicio</a></li>
                <li class="dropdown">
                    <a href="#"><i class="fas fa-info-circle"></i> Acerca de</a>
                </li>
                <li class="dropdown">
                    <a href="#"><i class="fas fa-utensils"></i> Nuestro Menú <i class="fas fa-caret-down"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="comidas.html"><i class="fas fa-hamburger"></i> Comidas</a></li>
                        <li><a href="bebidas.html"><i class="fas fa-coffee"></i> Bebidas</a></li>
                        <li><a href="postres.html"><i class="fas fa-ice-cream"></i> Postres</a></li>
                        <li><a href="demas.html"><i class="fas fa-ellipsis-h"></i> Demás</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#"><i class="fas fa-phone"></i> Contáctanos <i class="fas fa-caret-down"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="https://www.whatsapp.com"><i class="fab fa-whatsapp"></i> WhatsApp</a></li>
                        <li><a href="https://www.facebook.com/itjamc"><i class="fab fa-facebook"></i> Facebook</a></li>
                        <li><a href="https://www.instagram.com/instituto_juancho/"><i class="fab fa-instagram"></i> Instagram</a></li>
                        <li><a href="https://www.google.com/maps/place/Instituto+T%C3%A9cnico+Juan+Alberto+Melgar+Castro/@14.9842211,-88.0204976,16.96z/data=!4m9!1m2!2m1!1sca%C3%B1averal!3m5!1s0x8f65d7846df8a6db:0xaa1172c4ec1a7b11!8m2!3d14.9836277!4d-88.0182472!16s%2Fg%2F1hdzpq346?entry=ttu"><i class="fas fa-map-marker-alt"></i> Ubicación</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#"><i class="fas fa-envelope"></i class="fas fa-caret-down"> Formulario</a>
                    <ul class="dropdown-menu">
                            <li><a href="reserva_formulario.php"><i class="fas fa-edit"></i> Reserva</a></li>
                            <li><a href="facturacion.php"><i class="fas fa-user-check"></i> Factura</a></li>
                            <li><a href="reserva_paginacion.php"><i class="fas fa-user-group"></i> Paginacion</a></li>
    
                        </ul>
                </li>
            </ul>
        </nav>
    </header>
    <div class="container">
        <h1>Factura-Pedidos</h1>

        <form id="invoice_form" method="POST" action="guardar_factura.php">
    <div class="invoice-number">
        <label for="invoice_number">Número de Factura:</label>
        <input type="text" id="invoice_number" name="numero_factura" readonly>
    </div>

    <table>
        <thead>
            <tr>
                <th>Platillo</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody id="invoice_table_body">
            <!-- Aquí se agregarán las filas con los platillos -->
        </tbody>
    </table>

    <div class="totals">
        <div class="form-group">
            <label for="subtotal">Subtotal:</label>
            <input type="text" id="subtotal" name="subtotal" readonly>
        </div>
        <div class="form-group">
            <label for="isv">ISV (15%):</label>
            <input type="text" id="isv" name="isv" readonly>
        </div>
        <div class="form-group">
            <label for="total">Total a Pagar:</label>
            <input type="text" id="total" name="total" readonly>
        </div>
    </div>

    <div class="bottom-buttons">
        <button type="button" onclick="newInvoice()">Nueva Factura</button>
        <button type="button" onclick="saveInvoice()">Guardar Factura</button>
        <button type="button" onclick="showInvoice()">Mostrar Factura</button>
    </div>

    <div class="form-section">
        <div class="form-group">
            <label for="cliente_id">ID Cliente:</label>
            <input type="text" id="cliente_id" name="cliente_id" oninput="fetchClientData(this.value)" placeholder="Escribe ID del Cliente">
        </div>
        <div class="form-group">
            <input type="text" id="cliente_nombre" name="cliente_nombre" readonly>
        </div>
        <div class="form-group">
            <label for="platillo_id">ID Platillo:</label>
            <input type="text" id="platillo_id" name="platillo_id" oninput="fetchDishData(this.value)" placeholder="Escribe ID del Platillo">
        </div>
        <div class="form-group">
            <input type="text" id="platillo_nombre" name="platillo_nombre" readonly>
        </div>
        <div class="form-group">
            <label for="platillo_precio">Precio:</label>
            <input type="number" id="platillo_precio" name="platillo_precio" step="0.01" readonly>
        </div>
        <div class="form-group">
            <label for="quantity">Cantidad:</label>
            <input type="number" id="quantity" name="quantity" min="1" value="1">
        </div>
    </div>

    <div class="bottom-buttons">
        <button type="button" class="add-dish-button" onclick="addDish()">Agregar Platillo</button>
    </div>

    <input type="hidden" id="invoice_number_hidden" name="invoice_number" value="1000">
    <input type="hidden" id="productos" name="productos">
</form>

    </div>
    <script src="fscripts.js"></script>
    <div id="message" style="display: none; padding: 10px; margin: 10px 0; border: 1px solid #ddd; border-radius: 4px;"></div>

    <script>
        function submitForm() {
            const formData = new FormData(document.querySelector('form'));

            fetch('guardar_factura.php', { // Asegúrate de que este archivo sea el correcto
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                const messageDiv = document.getElementById('message');
                if (data.success) {
                    messageDiv.style.backgroundColor = '#d4edda'; // verde claro para éxito
                    messageDiv.style.color = '#155724'; // verde oscuro para texto
                } else {
                    messageDiv.style.backgroundColor = '#f8d7da'; // rojo claro para error
                    messageDiv.style.color = '#721c24'; // rojo oscuro para texto
                }
                messageDiv.innerText = data.message;
                messageDiv.style.display = 'block';
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }

        // Llama a submitForm cuando el formulario se envíe
        document.getElementById('facturacion-form').addEventListener('submit', function(e) {
            e.preventDefault();
            submitForm();
        });
    </script>
</body>
</html>
