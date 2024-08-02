<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "restaurante";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$id = $_GET['id'];

$sql = "DELETE FROM reserva WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    header("Location: reserva_formulario.php?mensaje=eliminado");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
