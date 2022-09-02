<?php

//$result = mysql_query("SELECT title,abstr,presenters,keywords,comments,outcomes,CategorySelection,research3,research4,innovation3,innovation4,references,organization FROM database.table WHERE id='$id' LIMIT 1;");
$conexion = new PDO('sqlite:C:\sombrerosDatabase\sombreros.db');

$result = $conexion->query('SELECT * FROM empleados');

$data = sqlite_fetch_array($result);
//$data = mysql_fetch_assoc($result);
$id = $data['id'];
$title = $data['nombreempleado'];
$abstract = $data['apellidoempleado'];
$presenters =$data['obsempleado'];
$outcomes =$data['empleadoactivo'];
/*
$keywords = $data['keywords'];
$CategorySelection =$data['CategorySelection']; //if not blank
$research3 =$data['research3']; //if not blank
$research4 =$data['research4']; //if not blank
$innovation3 =$data['innovation3']; //if not blank
$innovation4 =$data['innovation4']; //if not blank
$references =$data['references']; //if not blank
$organization =$data['organization']; //if not blank
$comments = $data['comments'];
*/


//create pdf
//require ('/opt/webapps/fpdf/fpdf.php');
require ('fpdf.php');

$pdf=new FPDF('P', 'mm', 'Letter');
$pdf->AddPage('P');

$pdf->SetFont('Arial','B',12);
$pdf->Write(5,$title);
$pdf->SetXY(10,25);

$pdf->Cell(20,10,"Abstract:",10,10);
$pdf->SetFont('Arial','',12);
$pdf->Write(5,$abstract);

$pdf->SetXY(10,60);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(20,20,"Presenters:",10,10);
$pdf->SetFont('Arial','',12);
$pdf->Write(5,$presenters);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(20,10,"Outcomes:",10,10);
$pdf->SetFont('Arial','',12);
$pdf->Write(5,$outcomes);

/*
$pdf->Cell(20,10,"Category: $CategorySelection",10,10);
$pdf->SetFont('Arial','B',12);
$pdf->MultiCell(180,6,"Indicate your teaching and learning project. ",10,10);
$pdf->SetFont('Arial','',12);
$pdf->Write(5,$research3);
$pdf->SetFont('Arial','B',12);
$pdf->MultiCell(180,6,"If your project involved a particular course, briefly describe the course, its students, and its place in the curriculum.",10,10);
$pdf->SetFont('Arial','',12);
$pdf->Write(5,$research4);

$pdf->SetFont('Arial','B',12);
$pdf->MultiCell(180,6,"Describe the planned innovation addressed in your paper. ",10,10);
$pdf->SetFont('Arial','',12);
$pdf->Write(5,$innovation3);
$pdf->SetFont('Arial','B',12);
$pdf->MultiCell(180,6,"If your innovation involves a particular course, briefly describe the course, its students, and its place in the curriculum.",10,10);
$pdf->SetFont('Arial','',12);
$pdf->Write(5,$innovation4Raw);
$pdf->SetFont('Arial','B',12);
$pdf->MultiCell(180,6,"How is your innovation different from ones that others have tried?",10,10);
$pdf->SetFont('Arial','',12);
$pdf->Write(5,$innovation5);
</code>
*/
$pdf->Output();

