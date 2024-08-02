<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Subir Platillo</title>
    <link rel="icon" href="./img/Logo.jpg" type="image/jpg" size="16x16">
    <!-- Incluyendo la librería de FontAwesome para los íconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Estilos generales para el cuerpo y el fondo */
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Estilos para el encabezado y el menú */
        header {
            width: 100%;
            background-color: #333;
            color: #fff;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            padding: 10px 20px;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
        }

        .logo img {
            height: 40px;
            vertical-align: middle;
            margin-right: 10px;
        }

        .logo span {
            font-size: 24px;
            font-weight: bold;
            vertical-align: middle;
        }

        .menu {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex;
        }

        .menu li {
            margin-left: 20px;
            position: relative;
        }

        .menu a {
            color: #fff;
            text-decoration: none;
            padding: 8px 12px;
            display: block;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .menu a:hover {
            background-color: #555;
            border-radius: 5px;
        }

        .dropdown:hover .dropdown-menu {
            display: block;
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            background-color: #444;
            min-width: 180px; /* Ajustar el ancho según sea necesario */
            border-radius: 5px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            z-index: 1;
            top: 100%; /* Mostrar debajo del elemento principal */
            left: 0; /* Alinear a la izquierda del elemento principal */
        }

        .dropdown-menu li {
            list-style-type: none; /* Eliminar los puntos de la lista */
        }

        .dropdown-menu a {
            padding: 10px;
            color: #fff;
            text-decoration: none;
            display: block;
            text-align: left;
        }

        .dropdown-menu a:hover {
            background-color: #555;
        }

        .fas, .fab {
            margin-right: 8px;
        }

        /* Ajuste para el espacio superior del contenido */
        main {
            margin-top: 80px; /* Ajustar según la altura del menú */
            padding: 20px;
            display: flex;
            justify-content: space-between;
            gap: 20px; /* Espacio entre el formulario y la tabla */
        }

        /* Estilos específicos para el formulario */
        .form-container {
            width: 45%;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input[type="text"], input[type="number"], input[type="file"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        input[type="submit"] {
            background-color: #ff5722;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }

        input[type="submit"]:hover {
            background-color: #e64a19;
        }

        img {
            max-width: 200px;
            max-height: 200px;
            display: block;
            margin-top: 10px;
        }

        /* Estilos para la tabla */
        .table-container {
            width: 55%;
        }

        .table-container table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .table-container th, .table-container td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        .table-container th {
            background-color: #ff5722;
            color: #fff;
        }

        .table-container tr:hover {
            background-color: #f1f1f1;
        }

        .button {
            background-color: #2196f3;
            color: white;
            padding: 5px 10px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            border-radius: 5px;
        }

        .button:hover {
            background-color: #1976d2;
        }

        .message {
            color: green;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <!-- Menú -->
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
                    <a href="Platillos_paginados.php"><i class="fas fa-envelope"></i> Paginacion Menu <i class="fas fa-caret-down"></i></a>
                </li>
            </ul>
        </nav>
    </header>

    <!-- Contenido principal -->
    <main>
        <div class="form-container">
            <h2>Agregar Platillo</h2>
            <form action="guardar_platillo.php" method="post" enctype="multipart/form-data">
                <label for="codigo">Código:</label>
                <input type="text" id="codigo" name="codigo" required>
                
                <label for="platillo">Platillo:</label>
                <input type="text" id="platillo" name="platillo" required>
                
                <label for="precio">Precio:</label>
                <input type="number" step="0.01" id="precio" name="precio" required>
                
                <label for="imagen">Imagen:</label>
                <input type="file" id="imagen" name="imagen" accept="image/*" onchange="previewImage(event)" required>
                
                <img id="preview" src="#" alt="Previsualización de la imagen" style="display: none;">
                
                <input type="submit" value="Guardar">
                <div class="message" id="message"></div>
            </form>
        </div>
        <div class="table-container">
            <h2>Platillos Existentes</h2>
            <table>
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Platillo</th>
                        <th>Precio</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $conn = new mysqli("localhost", "root", "", "restaurante");
                    if ($conn->connect_error) {
                        die("Conexión fallida: " . $conn->connect_error);
                    }
                    
                    $sql = "SELECT codigo, platillo, precio FROM menu";
                    $result = $conn->query($sql);
                    
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>{$row['codigo']}</td>
                                    <td>{$row['platillo']}</td>
                                    <td>{$row['precio']}</td>
                                    <td>
                                        <a href='actualizar_platillo.php?codigo={$row['codigo']}' class='button'>Actualizar</a>
                                        <a href='eliminar_platillo.php?codigo={$row['codigo']}' class='button' style='background-color: #f44336;'>Eliminar</a>
                                    </td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>No hay platillos</td></tr>";
                    }
                    
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </main>

    <script>
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('preview');
                output.src = reader.result;
                output.style.display = 'block';
            }
            reader.readAsDataURL(event.target.files[0]);
        }

        // Mostrar mensaje de éxito si hay uno en la URL
        document.addEventListener('DOMContentLoaded', function() {
            const params = new URLSearchParams(window.location.search);
            if (params.has('success')) {
                document.getElementById('message').innerText = "Platillo guardado exitosamente.";
            }
        });
    </script>
</body>
</html>
