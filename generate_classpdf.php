<?php
require('fpdf.php');
include('db.php');

$date = $_GET['date'];
$class = $_GET['class'];
$section = $_GET['section'];

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

$pdf->Cell(0, 10, "Class Attendance Sheet", 0, 1, 'C');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, "Date: $date | Class: $class | Section: $section", 0, 1, 'C');
$pdf->Ln(5);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(10, 10, "S.No", 1);
$pdf->Cell(60, 10, "Name", 1);
$pdf->Cell(30, 10, "Roll No", 1);
$pdf->Cell(30, 10, "Status", 1);
$pdf->Ln();

$sql = "SELECT * FROM attendance WHERE Date='$date' AND Class='$class' AND Section='$section'";
$result = $connection->query($sql);
$i = 1;

$pdf->SetFont('Arial', '', 12);
while ($row = $result->fetch_assoc()) {
    $pdf->Cell(10, 10, $i++, 1);
    $pdf->Cell(60, 10, $row['Name'], 1);
    $pdf->Cell(30, 10, $row['Roll_Number'], 1);
    $pdf->Cell(30, 10, $row['Status'], 1);
    $pdf->Ln();
}

$pdf->Output('I', "Class_Attendance_$date.pdf"); // 'I' means open in browser
?>
