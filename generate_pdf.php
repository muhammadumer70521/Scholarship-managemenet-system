<?php
require('fpdf.php');

// Create a new PDF document
$pdf = new FPDF();
$pdf->AddPage();

// Set font (use Arial to avoid font file issues)
$pdf->SetFont('Arial', 'B', 16);

// Add content
$pdf->Cell(0, 10, 'Scholarship Application Summary', 0, 1, 'C');
$pdf->SetFont('Arial', '', 12);

// Example student details (replace with real data)
$pdf->Ln(10); // Line break
$pdf->Cell(0, 10, 'Name: John Doe', 0, 1);
$pdf->Cell(0, 10, 'Course: Computer Science', 0, 1);
$pdf->Cell(0, 10, 'Scholarship Applied: Merit-Based', 0, 1);
$pdf->Cell(0, 10, 'Status: Pending', 0, 1);

// Output the PDF for download
$pdf->Output('D', 'scholarship_summary.pdf'); // 'D' forces download
?>
