<?php
// Conexión a la base de datos
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

// Consulta para obtener los datos de la tabla reserva
$sql = "SELECT id, cliente, cantidad_personas FROM reserva";
$result = $conn->query($sql);
?>
<?php
// Verificar si hay un mensaje
$mensaje = '';
if (isset($_GET['mensaje'])) {
    if ($_GET['mensaje'] == 'actualizado') {
        $mensaje = 'Reserva actualizada correctamente.';
    } elseif ($_GET['mensaje'] == 'eliminado') {
        $mensaje = 'Reserva eliminada correctamente.';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario de Reserva</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" href="./img/Logo.jpg" type="image/jpg" sizes="16x16">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
body {
    font-family: 'Arial', sans-serif;
    margin: 0;
    padding: 0;
    height: 100vh;
    background: rgba(117, 140, 186, 0.9);
    overflow: hidden;
}

.container {
    display: flex;
    justify-content: space-between;
    width: 90%;
    max-width: 1200px;
    margin: 40px auto;
    padding: 20px;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.form-container,
.table-container {
    width: 48%;
}

h1 {
    text-align: center;
    color: #7598ea;
    margin-bottom: 15px;
    font-size: 1.4em;
}

.form-group {
    display: flex;
    flex-wrap: wrap;
    margin-bottom: 10px;
}

.form-group label {
    flex: 0 0 30%;
    font-weight: bold;
    color: #333;
    margin-bottom: 4px;
}

.form-group input, 
.form-group select {
    flex: 1;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 14px;
    box-sizing: border-box;
    margin-left: 10px;
}

.form-group.full-width {
    flex-direction: column;
}

.submit-btn {
    display: block;
    width: 100%;
    padding: 10px;
    border: none;
    border-radius: 4px;
    background-color: #3cb1e7;
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

#mensaje {
    display: none;
    position: fixed;
    bottom: 10px;
    right: 10px;
    background: #d4edda;
    color: #155724;
    padding: 10px;
    border: 1px solid #c3e6cb;
    border-radius: 5px;
}

.table-container {
    width: 100%;
    max-height: 400px; /* Ajusta según sea necesario */
    overflow-y: auto;
    
    border-radius: 4px;
    background: #fff;
    margin-top: 20px;
    padding: 0 10px; /* Ajuste de padding */
}

.table-wrapper {
    position: relative;
}

.table-container h1 {
    position: sticky;
    top: 0;
    background: #fff;
    margin: 0;
    font-size: 1.2em;
    color: #7598ea;
    padding: 10px 0;
    border-bottom: 1px solid #ddd;
    z-index: 1;
}

table {
    width: 100%;
    border-collapse: collapse;
    table-layout: fixed; /* Ajusta el ancho de las columnas */
}

th, 
td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
    color: #333;
}

th {
    background-color: #a798eb;
    color: #fff;
}

tr:hover {
    background-color: #8abc8c;
    transform: scale(1.02);
    transition: all 0.3s;
}

.btn {
    background-color: #1b5f8d;
    color: #fff;
    border: none;
    padding: 5px 10px;
    text-decoration: none;
    border-radius: 4px;
    cursor: pointer;
}

.btn:hover {
    background-color: #1b5f8d;
}

.btn.eliminar {
    background-color: #651810 !important;
}

.btn.eliminar:hover {
    background-color: #651810 !important;
}

    </style>
    <script>
        function mostrarMensaje(texto) {
            const mensaje = document.getElementById('mensaje');
            mensaje.textContent = texto;
            mensaje.style.display = 'block';
            setTimeout(() => {
                mensaje.style.display = 'none';
            }, 3000);
        }

        function cargarTabla() {
            fetch('reserva_formulario.php') // Asegúrate de que esta ruta devuelva el HTML correcto
                .then(response => response.text())
                .then(data => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(data, 'text/html');
                    const tabla = doc.querySelector('.table-container table tbody');
                    document.querySelector('.table-container table tbody').innerHTML = tabla.innerHTML;
                })
                .catch(error => console.error('Error:', error));
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('reservaForm').addEventListener('submit', function(e) {
                e.preventDefault(); // Evita el envío por defecto del formulario
                
                const formData = new FormData(this);
                
                fetch('guardar_reserva.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        mostrarMensaje(data.message);
                        cargarTabla(); // Actualiza la tabla con los datos nuevos
                        this.reset(); // Limpia el formulario
                    } else {
                        mostrarMensaje(data.message);
                    }
                })
                .catch(error => console.error('Error:', error));
            });
        });
    </script>
</head>
<body>
<div id="mensaje"></div>
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
                    <li><a href="agregar_platillo.php"><i class="fas fa-utensils"></i> Platillos</a></li>

                </ul>
            </li>
        </ul>
    </nav>
</header>

<div class="container">
    <div class="form-container">
        <h1>Reserva de Mesa</h1>
        <form id="reservaForm">
            <div class="form-group">
                <label for="cliente">Nombre del Cliente:</label>
                <input type="text" id="cliente" name="cliente" required>
            </div>
            <div class="form-group">
                <label for="telefono">Teléfono:</label>
                <input type="text" id="telefono" name="telefono" required>
            </div>
            <div class="form-group">
                <label for="direccion">Dirección:</label>
                <input type="text" id="direccion" name="direccion" required>
            </div>
            <div class="form-group">
                <label for="correo">Correo Electrónico:</label>
                <input type="email" id="correo" name="correo">
            </div>
            <div class="form-group">
                <label for="cantidad_personas">Cantidad de Personas:</label>
                <input type="number" id="cantidad_personas" name="cantidad_personas" required>
            </div>
            <div class="form-group">
                <label for="hora_llegada">Hora de Llegada:</label>
                <input type="time" id="hora_llegada" name="hora_llegada" required>
            </div>
            <div class="form-group">
                <label for="hora_salida">Hora de Salida:</label>
                <input type="time" id="hora_salida" name="hora_salida" required>
            </div>
            <div class="form-group full-width">
                <label for="fecha">Fecha:</label>
                <input type="date" id="fecha" name="fecha" required>
            </div>
            <input type="submit" value="Guardar Reserva" class="submit-btn">
        </form>
    </div>
    
    <div class="table-container">
    <div class="table-wrapper">
        <h1>Reservas Actuales</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Cantidad de Personas</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Usar $conn en lugar de $conexion
                $query = "SELECT * FROM reserva";
                $result = $conn->query($query);
                
                if ($result) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['cliente'] . "</td>";
                        echo "<td>" . $row['cantidad_personas'] . "</td>";
                        echo "<td>";
                        echo "<a href='actualizar_reserva.php?id=" . $row['id'] . "' class='btn'>Actualizar</a> ";
                        echo "<a href='eliminar_reserva.php?id=" . $row['id'] . "' class='btn'style='background-color: #f44336;'>Eliminar</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>Error en la consulta: " . $conn->error . "</td></tr>";
                }
                $conn->close(); // Cerrar la conexión
                ?>
            </tbody>
        </table>
    </div>
    </div>
</div>
</body>
</html>
