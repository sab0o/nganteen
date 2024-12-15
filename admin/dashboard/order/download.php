<?php
session_start();

require('../../../fpdf/fpdf.php');
require '../../../connection.php';
global $con;

$pdf = new FPDF('L', 'mm', 'A4');
$pdf->AddPage();

$pdf->SetFont('Times', 'B', 13);
$pdf->Cell(0, 10, 'LAPORAN PENJUALAN', 0, 0, 'C');

$pdf->Cell(10, 15, '', 0, 1);
$pdf->SetFont('Times', 'B', 9);
$pdf->Cell(10, 7, 'NO', 1, 0, 'C');
$pdf->Cell(50, 7, 'NAME', 1, 0, 'C');
$pdf->Cell(75, 7, 'PRODUCT', 1, 0, 'C');
$pdf->Cell(50, 7, 'AMOUNT', 1, 0, 'C');
$pdf->Cell(50, 7, 'STATUS', 1, 0, 'C');



$pdf->Cell(10, 7, '', 0, 1);
$pdf->SetFont('Times', '', 10);
$id = $_SESSION['id'];

$sql = "SELECT checkout.id, checkout.status, customer.name AS cName, cart.amount, product.name AS pName FROM checkout JOIN customer ON checkout.customer_id = customer.id JOIN cart ON checkout.cart_id = cart.id JOIN product ON cart.product_id = product.id";

$a = $con->query($sql);

$no = 1;
while ($data = $a->fetch_assoc()) {
    $pdf->Cell(10, 6, $no++, 1, 0, 'C');
    
    $pdf->Cell(50, 6, $data['cName'], 1, 0);
    $pdf->Cell(75, 6, $data['pName'], 1, 0);
    $pdf->Cell(50, 6, $data['amount'], 1, 0);
    $pdf->Cell(50, 6, $data['status'], 1, 1);
}

$pdf->Output();