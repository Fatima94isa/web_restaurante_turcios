<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "restaurante";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener los datos del platillo
if (isset($_GET['codigo'])) {
    $codigo = $_GET['codigo'];

    $sql = "SELECT * FROM menu WHERE codigo=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $codigo);
    $stmt->execute();
    $result = $stmt->get_result();
    $platillo = $result->fetch_assoc();
    $stmt->close();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $codigo = $_POST['codigo'];
    $platillo = $_POST['platillo'];
    $precio = $_POST['precio'];

    // Define la ruta del directorio de destino
    $target_dir = __DIR__ . "/img/platillos/";

    // Asegúrate de que el directorio de destino existe
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true); // Crea el directorio si no existe
    }

    // Verifica si se subió una nueva imagen
    if (!empty($_FILES['imagen']['tmp_name'])) {
        // Define la ruta del archivo
        $target_file = $target_dir . basename($_FILES["imagen"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Verifica si el archivo es una imagen
        $check = getimagesize($_FILES["imagen"]["tmp_name"]);
        if ($check === false) {
            echo "El archivo no es una imagen.";
            $uploadOk = 0;
        }

        // Verifica el tamaño del archivo
        if ($_FILES["imagen"]["size"] > 500000) { // 500 KB
            echo "El archivo es demasiado grande.";
            $uploadOk = 0;
        }

        // Permite ciertos formatos de archivo
        if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
            echo "Solo se permiten archivos JPG, JPEG, PNG y GIF.";
            $uploadOk = 0;
        }

        // Verifica si $uploadOk está establecido a 0 por un error
        if ($uploadOk == 0) {
            echo "El archivo no se ha subido.";
        } else {
            // Mueve el archivo al directorio destino
            if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $target_file)) {
                $imagen_path = basename($_FILES["imagen"]["name"]);
                
                // Actualiza la base de datos con la nueva imagen
                $sql = "UPDATE menu SET platillo=?, precio=?, imagen=? WHERE codigo=?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssss", $platillo, $precio, $imagen_path, $codigo);
            } else {
                echo "Error al subir la imagen.";
            }
        }
    } else {
        // Si no se subió una nueva imagen, solo actualiza los otros campos
        $sql = "UPDATE menu SET platillo=?, precio=? WHERE codigo=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssd", $platillo, $precio, $codigo);
    }

    if ($stmt->execute()) {
        header("Location: agregar_platillo.php?updated=1");
    } else {
        echo "Error al actualizar el platillo: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Actualizar Platillo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
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
            max-width: 100%;
            max-height: 200px;
            margin-bottom: 15px;
            display: block;
        }
    </style>
</head>
<body>
    <form action="actualizar_platillo.php" method="post" enctype="multipart/form-data">
        <h2>Actualizar Platillo</h2>
        <label for="codigo">Código:</label>
        <input type="text" id="codigo" name="codigo" value="<?php echo htmlspecialchars($platillo['codigo']); ?>" readonly>
        
        <label for="platillo">Platillo:</label>
        <input type="text" id="platillo" name="platillo" value="<?php echo htmlspecialchars($platillo['platillo']); ?>" required>
        
        <label for="precio">Precio:</label>
        <input type="number" step="0.01" id="precio" name="precio" value="<?php echo htmlspecialchars($platillo['precio']); ?>" required>

        <label for="imagen">Imagen:</label>
        <input type="file" id="imagen" name="imagen" accept="image/*" onchange="previewImage(event)">
        
        <?php if (!empty($platillo['imagen'])): ?>
            <img id="currentImage" src="img/platillos/<?php echo htmlspecialchars($platillo['imagen']); ?>" alt="Imagen actual">
        <?php endif; ?>
        
        <img id="preview" src="#" alt="Previsualización de la imagen" style="display: none;">
        
        <input type="submit" value="Actualizar">
    </form>

    <script>
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('preview');
                output.src = reader.result;
                output.style.display = 'block';
                document.getElementById('currentImage').style.display = 'none';
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</body>
</html>
