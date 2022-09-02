<?php
require('mysql_table.php');

class PDF extends PDF_MySQL_Table
{
    function Header()
    {
        //Title
        $this->SetFont('Arial','',18);
        $this->Cell(0,6,'World populations',0,1,'C');
        $this->Ln(10);
        //Ensure table header is output
        parent::Header();
    }
}

//Connect to database
$conexion = new PDO('sqlite:C:\sombrerosDatabase\sombreros.db');

//mysql_connect('server','login','password');
//mysql_select_db('db');

$pdf=new PDF();
$pdf->AddPage();
//First table: put all columns automatically
$pdf->Table('select * from empleados');
$pdf->AddPage();
//Second table: specify 3 columns
$pdf->AddCol('rank',20,'','C');
$pdf->AddCol('name',40,'Country');
$pdf->AddCol('pop',40,'Pop (2001)','R');
$prop=array('HeaderColor'=>array(255,150,100),
    'color1'=>array(210,245,255),
    'color2'=>array(255,255,210),
    'padding'=>2);
$pdf->Table('select * from empleados',$prop);
$pdf->Output();
?>