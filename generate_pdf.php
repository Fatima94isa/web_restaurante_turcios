<?php
require('fpdf.php'); // Asegúrate de tener FPDF en tu servidor

$invoice_number = $_POST['invoice_number'];
$cliente_nombre = $_POST['cliente_nombre'];
$invoice_table_body = htmlspecialchars_decode($_POST['invoice_table_body']);
$subtotal = $_POST['subtotal'];
$isv = $_POST['isv'];
$total = $_POST['total'];

// Crear una instancia de FPDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

// Agregar contenido
$pdf->Cell(0, 10, 'Factura del Restaurante', 0, 1, 'C');
$pdf->Cell(0, 10, 'Número de Factura: ' . $invoice_number, 0, 1, 'C');
$pdf->Cell(0, 10, 'Cliente: ' . $cliente_nombre, 0, 1, 'C');

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Detalles de la Factura', 0, 1, 'L');
$pdf->SetFont('Arial', '', 12);

$pdf->Cell(0, 10, 'Subtotal: ' . $subtotal, 0, 1, 'R');
$pdf->Cell(0, 10, 'ISV: ' . $isv, 0, 1, 'R');
$pdf->Cell(0, 10, 'Total: ' . $total, 0, 1, 'R');

// Guardar el PDF en un archivo
$pdf->Output('D', 'factura_' . $invoice_number . '.pdf');
?>
