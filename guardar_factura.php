<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "restaurante";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener datos del formulario
$numero_factura = $_POST['invoice_number'];
$cliente_id = $_POST['cliente_id'];
$cliente_nombre = $_POST['cliente_nombre'];
$subtotal = $_POST['subtotal'];
$isv = $_POST['isv'];
$total = $_POST['total'];

$dish_names = $_POST['dish_names'];
$dish_prices = $_POST['dish_prices'];
$dish_quantities = $_POST['dish_quantities'];
$dish_totals = $_POST['dish_totals'];

// Iniciar la transacción
$conn->begin_transaction();

try {
    // Insertar datos en la tabla facturacion
    $sql_factura = "INSERT INTO facturacion (numero_factura, cliente_id, cliente_nombre, subtotal, isv, total)
                    VALUES (?, ?, ?, ?, ?, ?)";
    $stmt_factura = $conn->prepare($sql_factura);
    $stmt_factura->bind_param("iisddd", $numero_factura, $cliente_id, $cliente_nombre, $subtotal, $isv, $total);
    $stmt_factura->execute();
    
    $factura_id = $conn->insert_id;

    // Insertar datos en la tabla detalle_factura
    $sql_detalle = "INSERT INTO detalle_factura (factura_id, platillo_nombre, platillo_precio, cantidad, total)
                    VALUES (?, ?, ?, ?, ?)";
    $stmt_detalle = $conn->prepare($sql_detalle);
    
    foreach ($dish_names as $index => $dish_name) {
        $platillo_precio = $dish_prices[$index];
        $cantidad = $dish_quantities[$index];
        $total_platillo = $dish_totals[$index];
        $stmt_detalle->bind_param("isddd", $factura_id, $dish_name, $platillo_precio, $cantidad, $total_platillo);
        $stmt_detalle->execute();
    }

    // Confirmar la transacción
    $conn->commit();

    echo json_encode(['success' => true]);

} catch (Exception $e) {
    // Revertir la transacción en caso de error
    $conn->rollback();
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

// Cerrar conexión
$conn->close();

?>
