<?php
// include connection file 
require_once("db_conn.php");
session_start();

require('fpdf184/fpdf.php');

class PDF extends FPDF
{
    // Page header
    function Header()
    {

	$this->Image('logo/ShoeStore.png', 80, 5, 60);
	$this->Ln(10);
    $this->SetFont('Arial','B',13);
    $this->Cell(80);
	$this->Ln(10);

    $this->Ln(40);
    }

    // Page footer
    function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Vinit Mohanbhai Dabhi - 8804874', 0, 0, 'C');
    }
}

// Initialize PDF object
ob_clean();
$totalAmount = 0;
$pdf = new PDF();
$pdf->AddPage();
$account_id = $_SESSION['user_id'];
$result = mysqli_query($conn, "SELECT o.o_id, o.account_id, o.s_id, o.full_Name, o.address, o.zip_code, o.province, o.cardname, o.card_number, o.expiry, o.size, o.shoe_name, o.quantity, o.total, o.order_date, s.price FROM orders o JOIN shoe s ON o.s_id = s.s_id WHERE o.account_id = $account_id AND o.order_date = ( SELECT MAX(order_date) FROM orders WHERE account_id = $account_id );");
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);

    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(60, 10, 'Full Name: ' . $row['full_Name'], 0, 1);
    $pdf->Cell(60, 10, 'Address: ' . $row['address'], 0, 1);
    $pdf->Cell(60, 10, 'Zip Code: ' . $row['zip_code'], 0, 1);
    $pdf->Cell(60, 10, 'Province: ' . $row['province'], 0, 1);
    $pdf->Cell(60, 10, 'Card Number: ' . $row['card_number'], 0, 1);
    $pdf->Cell(60, 10, 'Card Name: ' . $row['cardname'], 0, 1);
    $pdf->Cell(60, 10, 'Order Number: ' . $row['o_id'], 0, 1);
    $pdf->Cell(60, 10, 'Order Date: ' . $row['order_date'], 0, 1);

    $pdf->Cell(0, 10, '-----------------------------------------------------------------------------------------------------------------------------------------', 0, 1, 'C');
    $pdf->Cell(60, 10, 'Shoe Name', 0, 0);
    $pdf->Cell(40, 10, 'Size', 0, 0);
    $pdf->Cell(40, 10, 'Quantity', 0, 0);
    $pdf->Cell(40, 10, 'Each Price', 0, 0);
    $pdf->Cell(50, 10, 'Total', 0, 1);
    $pdf->Cell(0, 10, '-----------------------------------------------------------------------------------------------------------------------------------------', 0, 1, 'C');

    $pdf->Cell(60, 10, $row['shoe_name'], 0, 0);
    $pdf->Cell(40, 10, $row['size'], 0, 0);
    $pdf->Cell(40, 10, $row['quantity'], 0, 0);
    $pdf->Cell(40, 10, '$'. $row['price'], 0, 0);
    $pdf->Cell(50, 10, '$' . $row['total'], 0, 1);

    // Loop through the rest of the rows to display the items
    $totalAmount += $row['total'];
    while ($row = mysqli_fetch_assoc($result)) {
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(60, 10, $row['shoe_name'], 0, 0);
        $pdf->Cell(40, 10, $row['size'], 0, 0);
        $pdf->Cell(40, 10, $row['quantity'], 0, 0);
        $pdf->Cell(40, 10, '$'. $row['price'], 0, 0);
        $pdf->Cell(50, 10, '$' . $row['total'], 0, 1);

        $totalAmount += $row['total'];
    }

    $pdf->Cell(0, 10, '-----------------------------------------------------------------------------------------------------------------------------------------', 0, 1, 'C');
    $pdf->Cell(190, 10, 'Overall Total: $' . $totalAmount, 0, 1, 'R');

    $pdf->Cell(160, 40, 'This is computer generated invoice you do not need to sign or verify.', 0, 1, 'R');
    
    // Output PDF
    $pdf->Output();
} else {
    // Handle the case when no rows are returned
    echo "No data found for the user.";
}
?>
