<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "restaurante";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$id = $_GET['id'];

// Consulta para obtener los datos de la reserva seleccionada
$sql = "SELECT * FROM reserva WHERE id=$id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "No se encontró la reserva";
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Reserva</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" href="./img/Logo.jpg" type="image/jpg" sizes="16x16">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        h1 {
            text-align: center;
            color: #e74c3c;
            margin-bottom: 20px;
            font-size: 1.8em;
        }
        form {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }
        .form-group {
            flex: 1;
            min-width: 300px;
        }
        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #333;
        }
        .form-group input, 
        .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            box-sizing: border-box;
        }
        .form-group.full-width {
            flex: 1 0 100%;
        }
        .submit-btn {
            display: block;
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 4px;
            background-color: #e74c3c;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
            text-align: center;
            margin-top: 20px;
        }
        .submit-btn:hover {
            background-color: #c0392b;
        }
    </style>
</head>
<header>
    <nav class="navbar">
        <div class="logo">
            <img src="./img/Logo22.png" alt="Logo">
            <span>Juancho's Restaurant</span>
        </div>
        <ul class="menu">
            <li><a href="index.html"><i class="fas fa-home"></i> Inicio</a></li>
            <li class="dropdown">
                <a href="acerca.html"><i class="fas fa-info-circle"></i> Acerca de</a>
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
                <a href="#"><i class="fas fa-envelope"></i> Formulario</a>
                <ul class="dropdown-menu">
                    <li><a href="reserva_formulario.php"><i class="fas fa-edit"></i> Reserva</a></li>
                    <li><a href="facturacion.php"><i class="fas fa-user-check"></i> Factura</a></li>
                    <li><a href="reserva_paginacion.php"><i class="fas fa-user-group"></i> Paginacion</a></li>
                </ul>
            </li>
        </ul>
    </nav>
</header>
<body>
    <div class="container">
        <h1>Actualizar Reserva</h1>
        <form action="guardar_actualizacion.php" method="POST">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
            <div class="form-group">
                <label for="cliente">Nombre del Cliente:</label>
                <input type="text" id="cliente" name="cliente" value="<?php echo htmlspecialchars($row['cliente']); ?>" required>
            </div>
            <div class="form-group">
                <label for="telefono">Teléfono:</label>
                <input type="text" id="telefono" name="telefono" value="<?php echo htmlspecialchars($row['telefono']); ?>" required>
            </div>
            <div class="form-group">
                <label for="direccion">Dirección:</label>
                <input type="text" id="direccion" name="direccion" value="<?php echo htmlspecialchars($row['direccion']); ?>" required>
            </div>
            <div class="form-group">
                <label for="cantidad_personas">Cantidad de Personas:</label>
                <input type="number" id="cantidad_personas" name="cantidad_personas" value="<?php echo htmlspecialchars($row['cantidad_personas']); ?>" required>
            </div>
            <div class="form-group">
                <label for="hora_llegada">Hora de Llegada:</label>
                <input type="time" id="hora_llegada" name="hora_llegada" value="<?php echo htmlspecialchars($row['hora_llegada']); ?>" required>
            </div>
            <div class="form-group">
                <label for="hora_salida">Hora de Salida:</label>
                <input type="time" id="hora_salida" name="hora_salida" value="<?php echo htmlspecialchars($row['hora_salida']); ?>" required>
            </div>
            <div class="form-group full-width">
                <label for="fecha">Fecha:</label>
                <input type="date" id="fecha" name="fecha" value="<?php echo htmlspecialchars($row['fecha']); ?>" required>
            </div>
            <input type="submit" value="Actualizar Reserva" class="submit-btn">
        </form>
    </div>
</body>
</html>
<?php $conn->close(); ?>
