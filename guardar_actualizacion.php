<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "restaurante";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$id = $_POST['id'];
$cliente = $_POST['cliente'];
$telefono = $_POST['telefono'];
$direccion = $_POST['direccion'];
$cantidad_personas = $_POST['cantidad_personas'];
$hora_llegada = $_POST['hora_llegada'];
$hora_salida = $_POST['hora_salida'];
$fecha = $_POST['fecha'];

$sql = "UPDATE reserva SET cliente='$cliente', telefono='$telefono', direccion='$direccion', cantidad_personas=$cantidad_personas, hora_llegada='$hora_llegada', hora_salida='$hora_salida', fecha='$fecha' WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    header("Location: reserva_formulario.php?mensaje=actualizado");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
