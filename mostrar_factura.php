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

// Verificar si el id está presente en la URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID de factura no especificado.");
}

$factura_id = intval($_GET['id']); // Asegúrate de que sea un entero

// Obtener los datos de la factura
$sql_factura = "SELECT * FROM facturacion WHERE id = ?";
$stmt_factura = $conn->prepare($sql_factura);
$stmt_factura->bind_param("i", $factura_id);
$stmt_factura->execute();
$result_factura = $stmt_factura->get_result();
$factura = $result_factura->fetch_assoc();

// Verificar si la factura fue encontrada
if (!$factura) {
    die("Factura no encontrada.");
}

// Obtener los detalles de la factura
$sql_detalle = "SELECT * FROM detalle_factura WHERE factura_id = ?";
$stmt_detalle = $conn->prepare($sql_detalle);
$stmt_detalle->bind_param("i", $factura_id);
$stmt_detalle->execute();
$result_detalle = $stmt_detalle->get_result();

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Factura #<?php echo htmlspecialchars($factura['numero_factura']); ?></title>
    <style>
        /* Estilos para la factura */
        body {
            font-family: Arial, sans-serif;
        }
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            font-size: 16px;
            line-height: 24px;
            color: #555;
        }
        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }
        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }
        .invoice-box table tr td:nth-child(2) {
            text-align: right;
        }
        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }
        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }
        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }
        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }
        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }
        .invoice-box table tr.item td{
            border-bottom: 1px solid #eee;
        }
        .invoice-box table tr.item.last td {
            border-bottom: none;
        }
        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="invoice-box">
        <table>
            <tr class="top">
                <td colspan="4">
                    <table>
                        <tr>
                            <td class="title">
                                <img src="logo.png" style="width: 100%; max-width: 300px;">
                            </td>
                            <td>
                                Factura #: <?php echo htmlspecialchars($factura['numero_factura']); ?><br>
                                Fecha: <?php echo htmlspecialchars($factura['fecha']); ?><br>
                                Cliente: <?php echo htmlspecialchars($factura['cliente_nombre']); ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="heading">
                <td>Platillo</td>
                <td>Cantidad</td>
                <td>Precio</td>
                <td>Total</td>
            </tr>

            <?php while ($detalle = $result_detalle->fetch_assoc()) { ?>
                <tr class="item">
                    <td><?php echo htmlspecialchars($detalle['platillo_nombre']); ?></td>
                    <td><?php echo htmlspecialchars($detalle['cantidad']); ?></td>
                    <td><?php echo htmlspecialchars($detalle['platillo_precio']); ?></td>
                    <td><?php echo htmlspecialchars($detalle['total']); ?></td>
                </tr>
            <?php } ?>

            <tr class="total">
                <td colspan="3"></td>
                <td>
                   Subtotal: <?php echo htmlspecialchars($factura['subtotal']); ?>
                </td>
            </tr>
            <tr class="total">
                <td colspan="3"></td>
                <td>
                   ISV: <?php echo htmlspecialchars($factura['isv']); ?>
                </td>
            </tr>
            <tr class="total">
                <td colspan="3"></td>
                <td>
                   Total a Pagar: <?php echo htmlspecialchars($factura['total']); ?>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
