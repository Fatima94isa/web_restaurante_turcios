let invoiceNumber = 1000;

function fetchClientData(clientId) {
    if (clientId) {
        fetch('fetch_client.php?id=' + clientId)
            .then(response => response.json())
            .then(data => {
                document.getElementById('cliente_nombre').value = data.cliente;
            });
    } else {
        document.getElementById('cliente_nombre').value = '';
    }
}

function fetchDishData(dishId) {
    if (dishId) {
        fetch('fetch_dish.php?id=' + dishId)
            .then(response => response.json())
            .then(data => {
                document.getElementById('platillo_nombre').value = data.platillo;
                document.getElementById('platillo_precio').value = data.precio;
            });
    } else {
        document.getElementById('platillo_nombre').value = '';
        document.getElementById('platillo_precio').value = '';
    }
}

function addDish() {
    const dishId = document.getElementById('platillo_id').value;
    const dishName = document.getElementById('platillo_nombre').value;
    const dishPrice = parseFloat(document.getElementById('platillo_precio').value);
    const quantity = parseInt(document.getElementById('quantity').value);

    if (dishId && dishName && dishPrice && quantity) {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td><input type="hidden" name="dish_names[]" value="${dishName}">${dishName}</td>
            <td><input type="hidden" name="dish_prices[]" value="${dishPrice.toFixed(2)}">${dishPrice.toFixed(2)}</td>
            <td><input type="hidden" name="dish_quantities[]" value="${quantity}">${quantity}</td>
            <td><input type="hidden" name="dish_totals[]" value="${(dishPrice * quantity).toFixed(2)}">${(dishPrice * quantity).toFixed(2)}</td>
        `;
        document.getElementById('invoice_table_body').appendChild(row);

        calculateTotals();
    } else {
        alert('Por favor, llena todos los campos del platillo antes de agregarlo.');
    }
}

function calculateTotals() {
    let subtotal = 0;
    const rows = document.getElementById('invoice_table_body').getElementsByTagName('tr');
    for (let row of rows) {
        subtotal += parseFloat(row.cells[3].textContent);
    }
    const isv = subtotal * 0.15;
    const total = subtotal + isv;

    document.getElementById('subtotal').value = subtotal.toFixed(2);
    document.getElementById('isv').value = isv.toFixed(2);
    document.getElementById('total').value = total.toFixed(2);
}

function newInvoice() {
    invoiceNumber++;
    document.getElementById('invoice_number').value = invoiceNumber;
    document.getElementById('invoice_number_hidden').value = invoiceNumber;
    document.getElementById('invoice_table_body').innerHTML = '';
    calculateTotals();
}

function saveInvoice() {
    const invoiceForm = document.getElementById('invoice_form');
    const invoiceData = new FormData(invoiceForm);
    
    fetch('guardar_factura.php', {
        method: 'POST',
        body: invoiceData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Factura guardada con éxito!');
            newInvoice();
        } else {
            alert('Error al guardar la factura. Por favor, inténtalo de nuevo.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

function showInvoice() {
    const clienteId = document.getElementById('cliente_id').value;
    const clienteNombre = document.getElementById('cliente_nombre').value;

    // Obteniendo los valores de los TextBox de Subtotal, ISV y Total a Pagar
    const subtotal = document.getElementById('subtotal').value;
    const isv = document.getElementById('isv').value;
    const total = document.getElementById('total').value;

    // Obtener las filas de la tabla de pedidos
    const tableRows = document.querySelectorAll('#invoice_table_body tr');

    let rowsHtml = '';
    tableRows.forEach(row => {
        const platilloNombre = row.querySelector('td:nth-child(1)').textContent;
        const platilloPrecio = parseFloat(row.querySelector('td:nth-child(2)').textContent);
        const cantidad = parseInt(row.querySelector('td:nth-child(3)').textContent);
        const totalPlatillo = parseFloat(row.querySelector('td:nth-child(4)').textContent);

        rowsHtml += `
            <tr>
                <td>${platilloNombre}</td>
                <td>${platilloPrecio.toFixed(2)}</td>
                <td>${cantidad}</td>
                <td>${totalPlatillo.toFixed(2)}</td>
            </tr>
        `;
    });

    const invoiceWindow = window.open('', 'Factura', 'width=800,height=600');
    invoiceWindow.document.write(`
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
            <title>Factura</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 20px; }
                .header { text-align: center; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
                .header img { width: 100px; }
                .header p { margin: 5px 0; }
                table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
                table, th, td { border: 1px solid #000; }
                th, td { padding: 8px; text-align: left; }
                th { background-color: #f2f2f2; }
                .totals { margin-top: 20px; font-size: 1.2em; }
                .footer { text-align: center; font-size: 0.9em; margin-top: 20px; }
                .button-container { text-align: center; margin-top: 20px; }
                .button { padding: 10px 20px; font-size: 16px; cursor: pointer; }
                .button-pdf { background-color: #007bff; color: #fff; border: none; }
                .button-pdf:hover { background-color: #0056b3; }
            </style>
        </head>
        <body>
            <div class="header">
                <img src="./img/Logo.jpg" alt="Logo">
                <h1>Factura Restaurante</h1>
                <p><strong>ID Cliente:</strong> ${clienteId}</p>
                <p><strong>Nombre Cliente:</strong> ${clienteNombre}</p>
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
                <tbody>
                    ${rowsHtml}
                </tbody>
            </table>
            <div class="totals">
                <p><strong>Subtotal:</strong> ${subtotal}</p>
                <p><strong>ISV (15%):</strong> ${isv}</p>
                <p><strong>Total a Pagar:</strong> ${total}</p>
            </div>
            <div class="footer">
                <p>Gracias por su compra!</p>
            </div>
        </body>
        </html>
    `);
}


// Inicializar nueva factura
newInvoice();

document.getElementById('download_pdf_btn').addEventListener('click', function () {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();
    
    // Captura los datos del formulario
    const invoiceNumber = document.getElementById('invoice_number').value;
    const subtotal = document.getElementById('subtotal').value;
    const isv = document.getElementById('isv').value;
    const total = document.getElementById('total').value;
    
    // Añadir contenido al PDF
    doc.text('Factura Restaurante', 10, 10);
    doc.text('Número de Factura: ' + invoiceNumber, 10, 20);
    doc.text('Subtotal: ' + subtotal, 10, 30);
    doc.text('ISV (15%): ' + isv, 10, 40);
    doc.text('Total a Pagar: ' + total, 10, 50);
    
    // Añadir tabla de productos
    doc.text('Productos:', 10, 60);
    let yOffset = 70;
    const tableRows = document.querySelectorAll('#invoice_table_body tr');
    tableRows.forEach(row => {
        const cells = row.querySelectorAll('td');
        const description = cells[0].innerText;
        const price = cells[1].innerText;
        const quantity = cells[2].innerText;
        const total = cells[3].innerText;
        doc.text(`${description} - Precio: ${price} - Cantidad: ${quantity} - Total: ${total}`, 10, yOffset);
        yOffset += 10;
    });
    
    // Descarga el PDF
    doc.save('factura.pdf');
});
