<?php
// include connection file 
include "dbconnect.php";
require('fpdf184/fpdf.php');


class PDF extends FPDF
{
   // Page header
function Header()
{
    
    // Logo

	$this->Image('logo/conestogalogo.png',95,10,20);
	$this->Ln(10);
    $this->Ln(40);

}
}

$pdf = new PDF();

$result = mysqli_query($conn, "SELECT d.student,student.Studnet_name,student.Student_ID, student.Student_Email, d.Student_Letter_Grade as d_Letter_Grade, d.Student_Course_Title as d_Course_Title, j.Student_Letter_Grade as j_Letter_Grade, j.Student_Course_Title as  
j_Course_Title FROM student INNER JOIN data_base as d ON student.ID = d.student_ID") or die("database error:". mysqli_error($conn));

while ($row = mysqli_fetch_assoc($result)) {

    $pdf->Text(0, 10, 'Name of the student: ' . $Name);
    $pdf->Text(0, 10, 'Date: ' . date('d-m-Y'));
    $pdf->Text(0, 10, 'Student ID: ' . $ID);
    $pdf->Ln(20);
    $pdf->Text(0, 10, $Course_Title);
    $pdf->Text(-30, 10, $Letter_Grade);
    $pdf->Text(0, 10, $Course_Title);
    $pdf->Text(-30, 10, $j_Letter_Grade);
    $pdf->Ln(40);
    $pdf->Text(0, 10, "-------------"));
    $pdf->Text(155);
    $pdf->Text(0, 10, 'Signature');
    $pdf->Ln(100);
}

// Output PDF
$pdf->Output();
?>
