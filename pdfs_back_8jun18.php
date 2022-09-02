
<?php

require('fpdf.php');

$fecha1 =  $_POST["date1"];
$fecha2 =  $_POST["date2"];

$fechaini=$fecha1;
$fechafin=$fecha2;

//$fecha1enc = $fecha1;
//$fecha2enc = $fecha2;
//Cambia de formato la fecha
//Fecha inicial
    //$date1 = date_create_from_format('d/m/Y', $fecha1);
//$fechaini = date_format($date1, 'Y-m-d');
$fecha1enc = date("d/m/Y", strtotime($fecha1));
$fecha2enc = date("d/m/Y", strtotime($fecha2));
//fecha final
    //$date2 = date_create_from_format('d/m/Y', $fecha2);
    //$fechafin = date_format($date2, 'Y-m-d');

//echo "fecha 1 " .$fecha1 ." al " .$fecha2;

//echo "fecha " .$fecha1enc;

class PDF extends FPDF
{
// Cabecera de página
    function Header()
    {
        global $fecha1enc;
        global $fecha2enc;
        // Logo
        $this->Image('logosombreros.jpg', 10, 8, 53);
        //Image('nombrearchivo',margen izquierdo, margensuperior, tamaño)
        // Arial bold 15
        $this->SetFont('Arial', 'B', 15);
        // Movernos a la derecha
        $this->Cell(80);
        // Título
        $this->Cell(100, 10, 'Reporte de producción', 0, 1, 'C');
        $this->Cell(80);
        $this->Cell(100, 10, "Del: " .$fecha1enc . " al: " . $fecha2enc, 0, 1, 'C');
        $this->Cell(80);
        $this->Line(10,30,205,30);
        // Salto de línea
        $this->Ln(4);
    }

// Pie de página
    function Footer()
    {
        // Posición: a 1,5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Número de página
        $this->Cell(0, 10, 'Página ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}



//////// CONEXION A LA BASE DE DATOS //////////////
$con=mysqli_connect("localhost","root","","sombrerosoficina");
// Check connection
if (mysqli_connect_errno())
{
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}


////////// ID MAXIMO
$idempleadoarray = array();
$sql2 = "SELECT MAX(idempleado_prod) FROM produccion";
$resultado = mysqli_query($con, $sql2);

if (mysqli_num_rows($resultado) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($resultado)) {
       //echo "id Máximo del empleado es : " . $row["MAX(idempleado_prod)"]."<br>";
        $idempleadoarray[] = $row['MAX(idempleado_prod)'];
    }
} else {
    echo "0 results";
}

//echo "<br> el id Maximo del empleado desde aray es: ". $idempleadoarray[0];

//ENCABEZADO DE EMPLEADOS
$idemp= array();
$nombreemp = array();
$apellidoemp = array();

for ($id = 1 ; $id <= $idempleadoarray[0]; $id++) {
    $sql4 = "SELECT idempleado_prod, nombreempleado, apellidoempleado FROM  produccion  WHERE idempleado_prod = " . $id . " ";

    if (!$result = $con->query($sql4)) {
        die('There was an error running the query [' . $db->error . ']');
    }

    while ($row = $result->fetch_assoc()) {
        //echo $row['idtableta'] . '<br />';
        //print "<tr><td>".$row['idtableta']."</td>";
        $idemp[$id] = $row['idempleado_prod'];
        $nombreemp[$id] = $row['nombreempleado'];
        $apellidoemp[$id] = $row['apellidoempleado'];

    }
}


///////   SUMA DE IMPORTES POR EMPLEADO
$totalemp= array();

for ($id = 1 ; $id <= $idempleadoarray[0]; $id++) {
    $sql5 = "SELECT SUM(importe) FROM produccion where idempleado_prod = " . $id . " AND fechaprod >= '". $fechaini . "' AND fechaprod <= '" .$fechafin . "'";
    //SELECT SUM(importe) FROM produccion where idempleado_prod = 1 AND fechaprod >= '2016-01-18' and fechaprod <= '2016-01-19'
    if (!$result = $con->query($sql5)) {
        die('There was an error running the query [' . $db->error . ']');
    }

    while ($row = $result->fetch_assoc()) {
        $totalemp[$id] = $row['SUM(importe)'];

    }
}


//SELECT SUM(importe) FROM produccion where idempleado_prod = 1




    $cars = array("Volvo", "BMW", "Toyota");
    $arrlength = count($cars);

    $encabezado = array("idtableta", "fecha");
    $tamanoenc = count($encabezado);


// Creación del objeto de la clase heredada
//$pdf = new PDF();
//$pdf->AliasNbPages();



    //constructor de la clase FPDF
$pdf = new PDF('P', 'mm', 'letter');
    //crea una nueva paquina
$pdf->AddPage();
    //es obligatorio escoger una fuente
$pdf->SetFont('Arial', 'B', 14);
$pdf->AliasNbPages();
//Celda  Cell(ancho, alto, texto, borde, posicion antes de invocar, alineacion, fondo, link)
 $pdf->Ln();
//array simple



////  REPORTES POR EMPLEADOS

//print "<BR><p>Comienzo de reportes por empleado</p>\n";
for ($id = 1 ; $id <= $idempleadoarray[0]; $id++) {

    if($totalemp[$id]>0) {
        $pdf->SetFont('Arial','B',12);
        //print "<p>$id</p>\n";
        $pdf->Cell(102, 10, "No. Emp.: " . $idemp[$id] . "  Nombre:  " . $nombreemp[$id] . " " . $apellidoemp[$id], 0, 1, 'L');
        $pdf->Ln(1);

        $pdf->SetFont('Arial','B',8);
        //encabezados
        $pdf->Cell(20, 6, 'Id tableta', 1, 0, 'C');
        $pdf->Cell(20, 6, 'Fecha ', 1, 0, 'C');
        // $pdf->Cell(10, 10, 'id emp. ', 1, 0, 'C');
        //$pdf->Cell(30, 10, 'nombre', 1, 0, 'C');
        //$pdf->Cell(40, 10, 'apellido', 1, 0, 'C');
        $pdf->Cell(20, 6, 'Cant', 1, 0, 'C');
        $pdf->Cell(40, 6, 'Trabajo', 1, 0, 'C');
        $pdf->Cell(45, 6, 'Descripción', 1, 0, 'C');
        $pdf->Cell(15, 6, 'Precio', 1, 0, 'C');
        $pdf->Cell(20, 6, 'Importe', 1, 1, 'C');


/////////////////



        //$sql3 = "SELECT * FROM  produccion  WHERE idempleado_prod = " . $id . " AND fechaprod >= '" . $fechaini . "' and fechaprod <='" . $fechafin . "'";
        $sql3 = "SELECT idtableta, DATE_FORMAT(fechaprod, '%d-%m-%Y') as datofecha , cant,descripciontrabajo, descprod,precioprod,importe
          FROM  produccion  WHERE idempleado_prod = " . $id . " AND fechaprod >= '" . $fechaini . "' and fechaprod <='" . $fechafin . "'";
//echo $sql3 ;

        $arrayprecio = array();
        if (!$result = $con->query($sql3)) {
            die('There was an error running the query [' . $db->error . ']');
        }

        while ($row = $result->fetch_assoc()) {

            $pdf->SetFont('Arial','',8);
            //Celda  Cell(ancho, alto, texto, borde, posicion antes de invocar, alineacion, fondo, link)
            $pdf->Cell(20, 6, $row['idtableta'], 1, 0, 'C');
            $pdf->Cell(20, 6, $row['datofecha'], 1, 0, 'C');
            //  $pdf->Cell(10, 10, $row['idempleado_prod'], 1, 0, 'C');
            // $pdf->Cell(30, 10, $row['nombreempleado'], 1, 0, 'C');
            // $pdf->Cell(40, 10, $row['apellidoempleado'], 1, 0, 'C');
            $pdf->Cell(20, 6, $row['cant'], 1, 0, 'C');
            $pdf->Cell(40, 6, $row['descripciontrabajo'], 1, 0, 'C');
            $pdf->Cell(45, 6, $row['descprod'], 1, 0, 'C');
            $pdf->Cell(15, 6, "$ " . number_format($row['precioprod'],2,".",","), 1, 0, 'R');
            $pdf->Cell(20, 6, "$ " . number_format($row['importe'],2,".",","), 1, 1, 'R');
        }
        $pdf->SetFont('Arial','B',9);
        $pdf->Cell(180, 8, "TOTAL $ " . number_format( $totalemp[$id],2,".",","), 1, 1, 'R');
        $pdf->Ln();
    }//fin del if
}
//////////// CREA PDF



/*
// Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->AliasNbPages();
//añade pagina de reporte x trabajador
$pdf->AddPage();
//es obligatorio escoger una fuente
$pdf->SetFont('Arial', 'B', 10);
//Celda  Cell(ancho, alto, texto, borde, posicion antes de invocar, alineacion, fondo, link)
$pdf->Cell(40, 10, 'LISTA DE RAYA');
$pdf->Ln();
*/

//añade pagina de reporte x trabajador
$pdf->AddPage();
$pdf->Ln();
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0, 10, 'NOMINA DEL CENTRO DE TRABAJO MOCTEZUMA No. 307 ', 0, 1, 'C');
$pdf->Cell(0, 10, 'COL. NUEVO MÉXICO, OAXACA DE JUÁREZ, OAX. ', 0, 0, 'C');
$pdf->Ln();

$pdf->Ln();

/////////// LISTA DE RAYA
$pdf->SetFont('Arial','B',9);
//ENCABEZADO

$pdf->Cell(20, 10, 'No. ', 1, 0, 'C');
//$pdf->Cell(20, 10, 'No. Emp ', 1, 0, 'C');
$pdf->Cell(80, 10, 'Nombre ', 1, 0, 'C');
$pdf->Cell(30, 10, 'Importe ', 1, 0, 'C');
$pdf->Cell(50, 10, 'Firma ', 1, 1, 'C');

$arraytotal = array();

$num = 0;
for ($id = 1 ; $id <= $idempleadoarray[0]; $id++) {
    if($totalemp[$id]>0) {
        $num++;
        //se almacena en un array con formato de numero
        $arraytotal[$id] = number_format($totalemp[$id] ,2,".",",");
        $pdf->SetFont('Arial','',9);
        $pdf->Cell(20, 8, $num, 1, 0, 'C');
        //$pdf->Cell(20, 8, $idemp[$id], 1, 0, 'C');
        $pdf->Cell(80, 8, " " . $nombreemp[$id] . " " . $apellidoemp[$id] . " ", 1, 0, 'L');
        $pdf->Cell(30, 8,"$ ". $arraytotal[$id], 1, 0, 'R');
        $pdf->Cell(50, 8, " ", 1, 1, 'C');
    }

}
//echo money_format('%(#10n', $number) . "\n";

///// FIN LISTA DE RAYA


//$vistaPrecio = number_format($precio ,3,",",".");

//$pdf->Cell(3.5,1,$vistaPrecio);




$pdf->Output();
//cierra la base de datos
mysqli_close($con);




?>



