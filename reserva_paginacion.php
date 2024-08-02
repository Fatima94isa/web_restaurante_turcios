<?php
// reserva_paginacion.php
include 'conexion.php';

// Configuración de paginación
$registros_por_pagina = 10; // Número de registros por página
$pagina_actual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$offset = ($pagina_actual - 1) * $registros_por_pagina;

// Obtener el total de registros
$resultado_total = $conn->query("SELECT COUNT(*) AS total FROM reserva");
$total_registros = $resultado_total->fetch_assoc()['total'];
$total_paginas = ceil($total_registros / $registros_por_pagina);

// Obtener los registros para la página actual
$resultado = $conn->query("SELECT * FROM reserva LIMIT $offset, $registros_por_pagina");

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./img/Logo.jpg" type="image/jpg" size="16x16">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Paginación de Reservas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #003366;
            color: white;
            padding: 10px 0;
        }
        .navbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
        }
        .logo img {
            height: 50px;
        }
        .logo span {
            font-size: 24px;
            margin-left: 10px;
            font-weight: bold;
        }
        .menu {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
        }
        .menu li {
            margin: 0 10px;
            position: relative;
        }
        .menu a {
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            display: block;
        }
        .menu a:hover {
            background-color: #30216b;
            border-radius: 5px;
        }
        .dropdown-menu {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            background-color: #5d87b3;
            list-style: none;
            padding: 0;
            margin: 0;
            width: 200px;
            z-index: 1000;
        }
        .dropdown-menu li {
            border-bottom: 1px solid #8e424f;
        }
        .dropdown-menu a {
            padding: 10px;
            color: white;
        }
        .dropdown-menu a:hover {
            background-color: #5d87b3;
        }
        .dropdown:hover .dropdown-menu {
            display: block;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px;
            background-color: white;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #5ec6b7;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        /* Efecto hover en las filas */
        tr:hover {
            background-color: #83b0d7; /* Color de fondo al pasar el cursor sobre la fila */
            color: #000; /* Color del texto al pasar el cursor sobre la fila */
            transform: scale(1.02); /* Aumenta ligeramente el tamaño de la fila para un efecto de zoom */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Agrega una sombra sutil */
            transition: all 0.3s ease; /* Transición suave para todos los cambios */
        }
        .pagination {
            text-align: center;
            margin: 40px 0; /* Aumenta el margen superior para evitar la superposición con el menú */
        }
        .pagination a {
            display: inline-block;
            padding: 10px 15px;
            margin: 0 5px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #437eb9;
            color: black; /* Cambia el color del texto a negro */
            text-decoration: none;
        }
        .pagination a.active {
            background-color: #00b371;
            font-weight: bold;
        }
        .pagination a:hover {
            background-color: #00b371;
            color: white;
        }
        .pagination a.disabled {
            background-color: #ddd;
            color: #aaa;
            cursor: not-allowed;
            pointer-events: none;
        }
    </style>
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
                <a href="#"><i class="fas fa-envelope"></i> Formulario <i class="fas fa-caret-down"></i></a>
                <ul class="dropdown-menu">
                    <li><a href="reserva_formulario.php"><i class="fas fa-edit"></i> Reserva</a></li>
                    <li><a href="facturacion.php"><i class="fas fa-user-check"></i> Factura</a></li>
                    <li><a href="reserva_paginacion.php"><i class="fas fa-user-group"></i> Paginación</a></li>
                    <li><a href="agregar_platillo.php"><i class="fas fa-utensils"></i> Platillos</a></li>
                </ul>
            </li>
        </ul>
    </nav>
</header>

<?php if ($resultado->num_rows > 0): ?>

    <table>
        <tr>
            <th>ID</th>
            <th>Cliente</th>
            <th>Teléfono</th>
            <th>Dirección</th>
            <th>Cantidad de Personas</th>
            <th>Hora de Llegada</th>
            <th>Hora de Salida</th>
            <th>Fecha</th>
        </tr>
        <?php while ($fila = $resultado->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($fila['id']); ?></td>
                <td><?php echo htmlspecialchars($fila['cliente']); ?></td>
                <td><?php echo htmlspecialchars($fila['telefono']); ?></td>
                <td><?php echo htmlspecialchars($fila['direccion']); ?></td>
                <td><?php echo htmlspecialchars($fila['cantidad_personas']); ?></td>
                <td><?php echo htmlspecialchars($fila['hora_llegada']); ?></td>
                <td><?php echo htmlspecialchars($fila['hora_salida']); ?></td>
                <td><?php echo htmlspecialchars($fila['fecha']); ?></td>
            </tr>
        <?php endwhile; ?>
    </table>

    <div class="pagination">
        <?php if ($pagina_actual > 1): ?>
            <a href="reserva_paginacion.php?pagina=<?php echo $pagina_actual - 1; ?>">« Anterior</a>
        <?php else: ?>
            <a href="#" class="disabled">« Anterior</a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
            <a href="reserva_paginacion.php?pagina=<?php echo $i; ?>" class="<?php echo $i == $pagina_actual ? 'active' : ''; ?>">
                <?php echo $i; ?>
            </a>
        <?php endfor; ?>

        <?php if ($pagina_actual < $total_paginas): ?>
            <a href="reserva_paginacion.php?pagina=<?php echo $pagina_actual + 1; ?>">Siguiente »</a>
        <?php else: ?>
            <a href="#" class="disabled">Siguiente »</a>
        <?php endif; ?>
    </div>

<?php else: ?>
    <p>No se encontraron reservas.</p>
<?php endif; ?>

</body>
</html>
