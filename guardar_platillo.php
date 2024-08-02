<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "restaurante";

// Conectar a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
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
    
    // Verifica si se subió una imagen
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

                // Insertar el platillo con la nueva imagen en la base de datos
                $sql = "INSERT INTO menu (codigo, platillo, precio, imagen) VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssds", $codigo, $platillo, $precio, $imagen_path);
            } else {
                echo "Error al subir la imagen.";
            }
        }
    } else {
        // Si no se subió una imagen, insertar el platillo sin imagen en la base de datos
        $sql = "INSERT INTO menu (codigo, platillo, precio) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssd", $codigo, $platillo, $precio);
    }

    if ($stmt->execute()) {
        header("Location: agregar_platillo.php?success=1");
    } else {
        echo "Error al guardar el platillo: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
