<?php
header('Content-Type: application/json'); // Para indicar que se devolverá JSON

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "restaurante";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(array("status" => "error", "message" => "Conexión fallida: " . $conn->connect_error));
    exit();
}

$cliente = $_POST['cliente'];
$telefono = $_POST['telefono'];
$direccion = $_POST['direccion'];
$cantidad_personas = $_POST['cantidad_personas'];
$hora_llegada = $_POST['hora_llegada'];
$hora_salida = $_POST['hora_salida'];
$fecha = $_POST['fecha'];

$sql = "INSERT INTO reserva (cliente, telefono, direccion, cantidad_personas, hora_llegada, hora_salida, fecha) VALUES ('$cliente', '$telefono', '$direccion', $cantidad_personas, '$hora_llegada', '$hora_salida', '$fecha')";

if ($conn->query($sql) === TRUE) {
    echo json_encode(array("status" => "success", "message" => "Nueva reserva registrada correctamente"));
} else {
    echo json_encode(array("status" => "error", "message" => "Error: " . $conn->error));
}

$conn->close();
?>
