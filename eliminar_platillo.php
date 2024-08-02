<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "restaurante";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if (isset($_GET['codigo'])) {
    $codigo = $_GET['codigo'];

    $sql = "DELETE FROM menu WHERE codigo=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $codigo);

    if ($stmt->execute()) {
        header("Location: agregar_platillo.php?deleted=1");
    } else {
        echo "Error al eliminar el platillo: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
