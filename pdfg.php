<?php
// include connection file 
require_once("db_conn.php");

require('fpdf184/fpdf.php');


class PDF extends FPDF
{
   // Page header
function Header()
{
    
    // Logo

	$this->Image('logo/conestogalogo.png',95,10,20);
	$this->Ln(10);
    $this->SetFont('Arial','B',13);
    // Move to the right
    $this->Cell(80);
    // Title
    $this->Cell(30,20,'Solo Squad',0,0,'C');
	$this->Ln(10);
    $this->Cell(190,20,'Clothing Store',0,0,'C');

    // Line break
    $this->Ln(30);

}

// Page footer
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Page number
    $this->Cell(0,10,'Vinit Mohanbhai Dabhi - 8804874',0,0,'C');
}

}
 // Initialize PDF object
ob_clean();

$pdf = new PDF();
$pdf->AddPage();
$result = mysqli_query($conn, "SELECT UserName, COUNT(*) AS OrderCount FROM OrderDetails GROUP BY UserName ORDER BY OrderCount DESC LIMIT 3 ");
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'Top 3 Users by Order Count', 0, 1, 'C');

$pdf->SetFont('Arial', 'B', 12);
$tableWidth = 120;


// Get current position
$currentY = $pdf->GetY();
$currentX = $pdf->GetX();

// Calculate table height
$tableHeight = 10 * mysqli_num_rows($result);

// Calculate center position
$pageWidth = $pdf->GetPageWidth();
$pageHeight = $pdf->GetPageHeight();
$leftMargin = ($pageWidth - $tableWidth) / 2;
$topMargin = ($pageHeight - $tableHeight) / 2;

// Set left and top margins
$pdf->SetLeftMargin($leftMargin);
$pdf->SetTopMargin($topMargin);
$pdf->Cell($tableWidth/2, 10, 'User Name', 1, 0, 'C');
$pdf->Cell($tableWidth/2, 10, 'Total Order', 1, 1, 'C');

// Output table
while ($row = mysqli_fetch_assoc($result)) {
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell($tableWidth/2, 10, $row['UserName'], 1, 0, 'C');
    $pdf->Cell($tableWidth/2, 10, $row['OrderCount'], 1, 1, 'C');
}

// Reset left and top margins
$pdf->SetLeftMargin($currentX);
$pdf->SetTopMargin($currentY);

// Output PDF
$pdf->Output();


?>
