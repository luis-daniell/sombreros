<?php


require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// FORMATO
$spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(15);
$spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(45);
$spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(15);
$spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(15);
$spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(15);
$spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(15);
$spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(15);
$spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(15);
$spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(15);
$spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(15);
$spreadsheet->getActiveSheet()->getStyle('D3:D300')->getNumberFormat()
    ->setFormatCode('#,##0.00');

    $spreadsheet->getDefaultStyle()->getFont()->setName('Arial');
    $spreadsheet->getDefaultStyle()->getFont()->setSize(8);
//$spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);


$sheet->setTitle("nombre de la hoja");

$sheet->setCellValue('C1','PAGO SEMANAL DEL 23 DE JULIO AL 06 DE AGOSTO');
$sheet->setCellValue('D2','SUELDO 1 4%');
$sheet->setCellValue('E2','BONIF 1 5%');
$sheet->setCellValue('F2','SUELDO 2 4%');
$sheet->setCellValue('G2','BONIF 2 5%');
$sheet->setCellValue('H2','TOTAL');
$sheet->setCellValue('I2','DESC. PTO');
$sheet->setCellValue('J2','OTROS');
$sheet->setCellValue('K2','PAGO');

$sheet->setCellValue('A2','NO.');
$sheet->setCellValue('B2','NO. EMP');
$sheet->setCellValue('C2','NOMBRE');


// $fecha1 =  $_POST["date1"];
// $fecha2 =  $_POST["date2"];


// Fechas de las 2 semanas 

$fecha1= '04-07-2022';  // SEMANA 1
$fecha2= '08-07-2022'; 

$fechainiSEM1 = date("Y-m-d", strtotime($fecha1) );
$fechafinSEM1 = date("Y-m-d", strtotime($fecha2) );


$fecha3= '11-07-2022';  // SEMANA 2
$fecha4= '15-07-2022';

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


////////// ID MAXIMO
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
echo 'idempleadoarray[0] es _ ' . $idempleadoarray[0];





//SUMA LOS SALDOS
$totalemp= array();
$filaB = 3;
for ($id = 1 ; $id <= $idempleadoarray[0]; $id++) {
   
    $sql5 = "SELECT idempleado_prod, nombreempleado, SUM(importe) FROM produccion 
    where idempleado_prod = " .$id. " AND fechaprod >= '" .$fechainiSEM1 . "' AND fechaprod <= '" .$fechafinSEM1 . "' ";
    
    $sql6 = "SELECT idempleado_prod, nombreempleado, SUM(importe) FROM produccion 
    where idempleado_prod = " .$id. " AND fechaprod >= '" .$fechainiSEM2 . "' AND fechaprod <= '" .$fechafinSEM2 . "' ";

    //Inserta datos de acuerdo a la consulta sql5
    insertarDatos($sql5, $con);
    //Actualiza el saldo 2 de acuerdo a la consulta sql6
    updateDatos($sql6, $con, $id);
   
}







// $noconse = 1;
// $nofila = 3;
//  $sql6 = "SELECT idempleado_prod, nombreempleado, apellidoempleado, SUM(importe) as importe FROM produccion GROUP BY nombreempleado order by nombreempleado ";
//  if (!$result = $con->query($sql5)) {
//     die('There was an error running the query [' . $db->error . ']');
// }

// while ($row = $result->fetch_assoc()) {
//     $totalemp[$id] = $row['SUM(importe)'];
//  //   $sheet->setCellValue('B'.$filaB, 'empleado no: '. $id  . ' sum importe ' . $totalemp[$id]);
//     $sheet->setCellValue('A'.$nofila, $noconse);
//     $sheet->setCellValue('B'.$nofila, "id EMP : " .  $row['idempleado_prod']);
//     $sheet->setCellValue('C'.$nofila, $row['nombreempleado'] . " " . $row['apellidoempleado']);
//     $sheet->setCellValue('D'.$nofila, $row['SUM(importe)'] );
//     $sheet->setCellValue('E'.$nofila, $row['SUM(importe)'] * 0.05 );
//     $sheet->setCellValue('F'.$nofila, $row['SUM(importe)'] );
//     $sheet->setCellValue('G'.$nofila, $row['SUM(importe)'] * 0.05 );
//     echo 'empleado no: '. $id  . 'sum importe ' . $totalemp[$id];
//     $nofila++;
//     $noconse++;
// }


// $sql = "select idproduccion, nombreempleado, cant from produccion";
// echo $sql;
//  $resultado = $mysqli->$query('select * from produccion');





// $hojaActiva->setTitle("titulo");

 

// $fila = 2;

// // while( $rows = $resultado->fetch_assoc() ){
// //     $hojaActiva->setCellValue('A'.$fila, $rows['idproduccion']);
// //     $hojaActiva->setCellValue('A'.$fila, $rows['nombreempleado']);
// //     $hojaActiva->setCellValue('A'.$fila, $rows['cant']);
// //     $fila++;

// // }

// // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
// // header('Content-Disposition: attachment;filename="myfile.xlsx"');
// // header('Cache-Control: max-age=0');

// // $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($excel, 'Xlsx');
// // $writer->save('php://output');


// //$spreadsheet = new Spreadsheet();
// //$sheet = $spreadsheet->getActiveSheet();
// //$sheet->setCellValue('A1', 'Hello World !');

// // $writer = new Xlsx($excel);
// // $writer->save('hello world.xlsx');

// header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
// header('Content-Disposition: attachment;filename="myfile.xlsx"');
// header('Cache-Control: max-age=0');

// $writer =IOFactory::createWriter($spreadsheet, 'Xlsx');
// $writer->save('php://output');


$writer = new Xlsx($spreadsheet);
$writer->save('hello world.xlsx');
//mysqli_close($con);

// header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
// header('Content-Disposition: attachment;filename="Ejemplo Excel.xlsx"');
// header('Cache-Control: max-age=0');

// $writer =IOFactory::createWriter($spreadsheet, 'Xlsx');
// $writer->save('php://output');

// redirect output to client browser
// header('Content-Type: application/vnd.ms-excel');
// header('Content-Disposition: attachment;filename="myfile.xls"');
// header('Cache-Control: max-age=0');

// $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xls');
// $writer->save('php://output');




/**
 * FUNCIONES
 */

 
function insertarDatos($sql5, $con){
    if (!$result = $con->query($sql5)) {
        die('There was an error running the query [' . $db->error . ']');
    }

    
    while ($row = $result->fetch_assoc()) {


        if( !is_null( $row['idempleado_prod'])  and !is_null($row['nombreempleado'])){
            echo " --->  " .$row["idempleado_prod"]. " / " .$row["nombreempleado"]. " * ".$row["SUM(importe)"];
                $queryInsert = "INSERT INTO pagosemanal SET
                        idempleado = " .$row["idempleado_prod"]. ",
                        nombre = '" .$row["nombreempleado"]. "',
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
            echo " --->  " .$row["idempleado_prod"]. " / " .$row["nombreempleado"]. " * ".$row["SUM(importe)"];
                $queryUpdate = "UPDATE pagosemanal SET
                        sueldo2 = " .$row['SUM(importe)']. " ,
                        bon2 = " .(5 / 100) * $row["SUM(importe)"]. " WHERE idempleado = " .$id.  " ";
                $update = mysqli_query($con, $queryUpdate);
        }
    }    
}