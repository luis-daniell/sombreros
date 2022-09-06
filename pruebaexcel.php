<?php


require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;




// Fechas de las 2 semanas 

$fecha1= $_POST["fecha1"];  // '04-07-2022'
$fecha2= $_POST["fecha2"]; //'08-07-2022'

$fecha3= $_POST["fecha3"];  // '11-07-2022'
$fecha4= $_POST["fecha4"]; //'15-07-2022'



global $spreadsheet;
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();


$styleArray = [
    
    
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            'color' => ['argb' => '000000'],
        ],
    ],

    'alignment' => [
        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
    ],

];

$centrar = [
    
    
    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        //'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
    ],

];


$bold = [
    'font' => [
        'bold' => true,
    ],
];

$relleno = [
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'color' => ['argb' => 'C6E0B4'],
    ],

];

$rellenoColumn = [
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'color' => ['argb' => '99E5FF'],
    ],

];

$rellenoFila = [
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'color' => ['rgb' => '9BC2E6'],
    ],

];

// FORMATO
$spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(3);
$spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(8);
$spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(35);

$spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(14);
$spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(11);
$spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(14);
$spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(11);

$spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(10);
$spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(10);
$spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(10);
$spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(10);
$spreadsheet->getActiveSheet()->getColumnDimension('L')->setWidth(12);


//COMBINA CELDAS
$spreadsheet->getActiveSheet()->mergeCells('A1:L1');

//ESTABLECER FUENTE
$spreadsheet->getDefaultStyle()->getFont()->setName('Arial');
    $spreadsheet->getDefaultStyle()->getFont()->setSize(12);


//ALTURA PREDETERMINADA
$spreadsheet->getActiveSheet()->getDefaultRowDimension('A1:L38')->setRowHeight(21);

//Altura FILA
//$spreadsheet->getActiveSheet()->getRowDimension('2')->setRowHeight(30);

$spreadsheet->getActiveSheet()->getStyle('D3:H38')->getNumberFormat()
    ->setFormatCode('#,##0.00');
    
    
//Color Relleno columnas 
$spreadsheet->getActiveSheet()->getStyle('F3:F38')->applyFromArray($rellenoColumn);
$spreadsheet->getActiveSheet()->getStyle('D3:D38')->applyFromArray($relleno); 
//Relleno FIla
$spreadsheet->getActiveSheet()->getStyle('D2:G2')->applyFromArray($rellenoFila);
  
//Borde de celdas
$spreadsheet->getActiveSheet()->getStyle('A1:L38')->applyFromArray($styleArray); 
//Fuente bol
$spreadsheet->getActiveSheet()->getStyle('D2:L2')->applyFromArray($bold);   

//Centrar Titulo
$spreadsheet->getActiveSheet()->getStyle('A1')->applyFromArray($centrar);
$spreadsheet->getActiveSheet()->getStyle('D3:H38')->applyFromArray($centrar); 





    
//$spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);






//A1-L1

$mes1Dato1 = mesPalabra($fecha1);
$mes1Dato2 = mesPalabra($fecha2);
$fecha1Dato1 = diaNum($fecha1);
$fecha1Dato2 = diaNum($fecha2);
$year1 = date("Y", strtotime($fecha1));


$mes2Dato1 = mesPalabra($fecha3);
$mes2Dato2 = mesPalabra($fecha4);
$fecha2Dato1 = diaNum($fecha3);
$fecha2Dato2 = diaNum($fecha4);
$year2 = date("Y", strtotime($fecha4));


$titulo = "PAGO DEL $fecha1Dato1 DE $mes1Dato1 AL $fecha2Dato2 DE $mes2Dato2";


$sheet->setTitle("PAGO");
$sheet->setCellValue('A1', $titulo);
//$sheet->setCellValue('D1', $titulo2);
$sheet->setCellValue('D2','SUELDO 1 4%');
$sheet->setCellValue('E2','BONIF 1 5%');
$sheet->setCellValue('F2','SUELDO 2 4%');
$sheet->setCellValue('G2','BONIF 2 5%');
$sheet->setCellValue('H2','TOTAL');
$sheet->setCellValue('I2','DESC. PTO');
$sheet->setCellValue('J2','OTROS');
$sheet->setCellValue('K2','PAGO');
$sheet->setCellValue('L2','SALDO PTO.');

$sheet->setCellValue('A2','NO.');
$sheet->setCellValue('B2','NO. EMP');
$sheet->setCellValue('C2','NOMBRE');




// $fecha1 =  $_POST["date1"];
// $fecha2 =  $_POST["date2"];

//Fechas Formateadas
$fechainiSEM1 = date("Y-m-d", strtotime($fecha1) );
$fechafinSEM1 = date("Y-m-d", strtotime($fecha2) );
$fechainiSEM2 = date("Y-m-d", strtotime($fecha3) );
$fechafinSEM2 = date("Y-m-d", strtotime($fecha4) );





//////// CONEXION A LA BASE DE DATOS //////////////
$con=mysqli_connect("localhost","root","","sombrerosoficina");
// Check connection
if (mysqli_connect_errno())
{
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
} else {
    echo ' si se conecto a la base ---- ';
}



$borraT = "DROP TABLE IF EXISTS pagosemanal";
$result = mysqli_query($con, $borraT);

$sqlTabla = "CREATE TABLE IF NOT EXISTS pagosemanal (
    id INT AUTO_INCREMENT PRIMARY KEY,
    idempleado INT NOT NULL,
    nombre VARCHAR(255) NOT NULL,
    sueldo1 DECIMAL(10,2) DEFAULT 0,
    bon1 DECIMAL(10,2) DEFAULT 0,
    sueldo2 DECIMAL(10,2) DEFAULT 0,
    bon2 DECIMAL(10,2) DEFAULT 0
)";
$result = mysqli_query($con, $sqlTabla);

//echo ' resultao ' .$result; 1 si se hizo con exito


// ID MAXIMO
$idempleadoarray = array();
$sql2 = "SELECT MAX(idempleado_prod) FROM produccion";
$resultado = mysqli_query($con, $sql2);

if (mysqli_num_rows($resultado) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($resultado)) {
       echo "id Máximo del empleado es : " . $row["MAX(idempleado_prod)"]."<br>";
        $idempleadoarray[] = $row['MAX(idempleado_prod)'];
      //  $sheet->setCellValue('A2', "id Máximo del empleado es : " . $row["MAX(idempleado_prod)"]);
    }
} else {
    echo "0 results";
}




$filacon = 3;
//ENCABEZADO DE EMPLEADOS
$idemp= array();
$nombreemp = array();
$apellidoemp = array();



//SUMA LOS SALDOS
$totalemp= array();
$filaB = 3;
for ($id = 1 ; $id <= $idempleadoarray[0]; $id++) {
   
    $sql5 = "SELECT idempleado_prod, nombreempleado, apellidoempleado, SUM(importe) FROM produccion 
    where idempleado_prod = " .$id. " AND fechaprod >= '" .$fechainiSEM1 . "' AND fechaprod <= '" .$fechafinSEM1 . "' ";
    
    $sql6 = "SELECT idempleado_prod, nombreempleado, apellidoempleado, SUM(importe) FROM produccion 
    where idempleado_prod = " .$id. " AND fechaprod >= '" .$fechainiSEM2 . "' AND fechaprod <= '" .$fechafinSEM2 . "' ";

    //Inserta datos de acuerdo a la consulta sql5
    insertarDatos($sql5, $con);
    //Actualiza el saldo 2 de acuerdo a la consulta sql6
    updateDatos($sql6, $con, $id);
   
}



 $noconse = 1;
 $nofila = 3;


  $sql7 = "SELECT idempleado, nombre, sueldo1, bon1, sueldo2, bon2
  FROM pagosemanal order by nombre ASC ";

  if (!$result = $con->query($sql7)) {
     die('There was an error running the query [' . $db->error . ']');
 }

 while ($row = $result->fetch_assoc()) {
//  //   $sheet->setCellValue('B'.$filaB, 'empleado no: '. $id  . ' sum importe ' . $totalemp[$id]);
    $sheet->setCellValue('A'.$nofila, $noconse);
    $sheet->setCellValue('B'.$nofila, $row['idempleado']);
    $sheet->setCellValue('C'.$nofila, strtoupper($row['nombre']) ); 
    $sheet->setCellValue('D'.$nofila, "$".$row['sueldo1'] );
    $sheet->setCellValue('E'.$nofila, "$".$row['bon1']  );
    $sheet->setCellValue('F'.$nofila, "$".$row['sueldo2'] );
    $sheet->setCellValue('G'.$nofila, "$".$row['bon2']  );
    $sheet->setCellValue('H'.$nofila, "$".($row['sueldo1'] +  $row['bon1']  +  $row['sueldo2'] + $row['bon2']) );
    echo 'empleado no: '. $row['nombre']  . '';
    $nofila++;
    $noconse++;
}


$fileName = 'PAGO DEL '.$fecha1Dato1.' DE '.$mes1Dato1. ' AL ' .$fecha2Dato2.' DE '.$mes2Dato2.'.xlsx';
ob_clean();
$writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'. $fileName.'"');
        $writer->save('php://output');

        //header( "refresh:5;url=index.html" );        

/**
 * FUNCIONES
 */

 
function insertarDatos($sql5, $con){
    if (!$result = $con->query($sql5)) {
        die('There was an error running the query [' . $db->error . ']');
    }

    
    while ($row = $result->fetch_assoc()) {


        if( !is_null( $row['idempleado_prod'])  and !is_null($row['nombreempleado'])){
           
                $queryInsert = "INSERT INTO pagosemanal SET
                        idempleado = " .$row["idempleado_prod"]. ",
                        nombre = '" .$row["nombreempleado"]. " " .$row["apellidoempleado"]."',
                        sueldo1 = " .$row["SUM(importe)"]. ",
                        bon1 = " .(5 / 100) * $row["SUM(importe)"]. ",
                        sueldo2 = 0.0,
                        bon2 = 0.0";
                $insert = mysqli_query($con,$queryInsert);
        }
    }    
}


function updateDatos($sql6, $con, $id){
    if (!$result = $con->query($sql6)) {
        die('There was an error running the query [' . $db->error . ']');
    }

    
    while ($row = $result->fetch_assoc()) {

        
     

        if( !is_null( $row['idempleado_prod'])  and !is_null($row['nombreempleado'])){
            
                $queryUpdate = "UPDATE pagosemanal SET
                        sueldo2 = " .$row['SUM(importe)']. " ,
                        bon2 = " .(5 / 100) * $row["SUM(importe)"]. " WHERE idempleado = " .$id.  " ";
                $update = mysqli_query($con, $queryUpdate);
        }
    }    
}

function mesPalabra($fecha){

    $meses = ["ENERO", "FEBRERO", "MARZO", "ABRIL", "MAYO", "JUNIO", "JULIO", "AGOSTO", "SEPTIEMBRE", "OCTUBRE", "NOVIEMBRE", "DICIEMBRE"];
    
    $mesDato1 = date("m", strtotime($fecha) );
   

    for ($id = 1 ; $id <= 12; $id++) {
    
        if($mesDato1 == $id ){
            $mesD1 = $meses[$id - 1];
            echo " MES DATO " .$mesDato1;
        }
       
    
    }
    echo " -mes- " .$mesD1;

    return $mesD1;

}


function diaNum($fecha){

    
    $dia = date("d", strtotime($fecha) );
    echo " -DIA- " .$dia;
    return $dia;

}