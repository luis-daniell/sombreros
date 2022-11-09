<?php


require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;




// Fechas de las 2 semanas 

$fecha1= $_POST["fecha1"]; //'20-06-2022';//  // 
$fecha2= $_POST["fecha2"]; //'24-06-2022';// //

$fecha3= $_POST["fecha3"]; //'27-06-2022';//  // 
$fecha4= $_POST["fecha4"]; //'01-07-2022';// //



global $spreadsheet;
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();




// FORMATO
$spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(3);
$spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(8);
$spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(10);
$spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(35);

$spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(14);
$spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(11);
$spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(14);
$spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(11);

$spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(10);
$spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(10);
$spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(10);
$spreadsheet->getActiveSheet()->getColumnDimension('L')->setWidth(10);
$spreadsheet->getActiveSheet()->getColumnDimension('M')->setWidth(12);


//COMBINA CELDAS
$spreadsheet->getActiveSheet()->mergeCells('A1:L1');

//ESTABLECER FUENTE
$spreadsheet->getDefaultStyle()->getFont()->setName('Arial');
    $spreadsheet->getDefaultStyle()->getFont()->setSize(12);


//ALTURA PREDETERMINADA
$spreadsheet->getActiveSheet()->getDefaultRowDimension('A1:M38')->setRowHeight(21);

//Altura FILA
//$spreadsheet->getActiveSheet()->getRowDimension('2')->setRowHeight(30);

$spreadsheet->getActiveSheet()->getStyle('E3:H38')->getNumberFormat()
    ->setFormatCode('#,##0.00');
  


    
//Color Relleno columnas 
$spreadsheet->getActiveSheet()->getStyle('G3:G38')->applyFromArray(estilos('columna'));
$spreadsheet->getActiveSheet()->getStyle('E3:E38')->applyFromArray(estilos('relleno')); 
//Relleno FIla
$spreadsheet->getActiveSheet()->getStyle('E2:H2')->applyFromArray(estilos('fila'));
  
//Borde de celdas
$spreadsheet->getActiveSheet()->getStyle('A1:M38')->applyFromArray(estilos('estiloArray')); 
//Fuente bol
$spreadsheet->getActiveSheet()->getStyle('E2:M2')->applyFromArray(estilos('bold'));   

//Centrar Titulo
$spreadsheet->getActiveSheet()->getStyle('A1')->applyFromArray(estilos('centrar'));
$spreadsheet->getActiveSheet()->getStyle('E3:I38')->applyFromArray(estilos('centrar')); 





    
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
$sheet->setCellValue('E2','SUELDO 1 4%');
$sheet->setCellValue('F2','BONIF 1 5%');
$sheet->setCellValue('G2','SUELDO 2 4%');
$sheet->setCellValue('H2','BONIF 2 5%');
$sheet->setCellValue('I2','TOTAL');
$sheet->setCellValue('J2','DESC. PTO');
$sheet->setCellValue('K2','OTROS');
$sheet->setCellValue('L2','PAGO');
$sheet->setCellValue('M2','SALDO PTO.');

$sheet->setCellValue('A2','NO.');
$sheet->setCellValue('B2','NO. EMP');
$sheet->setCellValue('C2','TIP. PAGO');
$sheet->setCellValue('D2','NOMBRE');




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
        $maximo = $row['MAX(idempleado_prod)'];
      //  $sheet->setCellValue('A2', "id Máximo del empleado es : " . $row["MAX(idempleado_prod)"]);
    }
} else {
    echo "0 results";
}






//Guarda registros de la primera semana seleccionada
for ($id = 1 ; $id <= $maximo; $id++) {
   
    $sql5 = "SELECT idempleado_prod, nombreempleado, apellidoempleado, SUM(importe) FROM produccion 
    where idempleado_prod = " .$id. " AND fechaprod >= '" .$fechainiSEM1 . "' AND fechaprod <= '" .$fechafinSEM1 . "' ";
    
    //Inserta datos de acuerdo a la consulta sql5
    insertarDatos($sql5, $con);
   
}




//Guarda registros de la segunda semana seleccionada
for ($id = 1 ; $id <= $maximo; $id++) {
   
    $sql6 = "SELECT idempleado_prod, nombreempleado, apellidoempleado, SUM(importe) FROM produccion 
    where idempleado_prod = " .$id. " AND fechaprod >= '" .$fechainiSEM2 . "' AND fechaprod <= '" .$fechafinSEM2 . "' ";

    //Inserta datos de acuerdo a la consulta sql6
   
    insertarDatos2($sql6, $con);
    
   
}



 $noconse = 1;
 $nofila = 3;


  //$sql7 = "SELECT id, idempleado, nombre, SUM(sueldo1), 
  //SUM(bon1),SUM(sueldo2), SUM(bon2) FROM `pagosemanal` GROUP BY nombre; ";

    $sql7 = "SELECT pagosemanal.id, pagosemanal.idempleado as 'idempleado', pagosemanal.nombre as 'nombre', SUM(pagosemanal.sueldo1) as 'sueldo1', SUM(pagosemanal.bon1) as 'bon1', SUM(pagosemanal.sueldo2) as 'sueldo2', SUM(pagosemanal.bon2) as 'bon2', empleados.tipoPago as 'tipo' FROM pagosemanal inner join empleados on pagosemanal.idempleado = empleados.idempleado  GROUP BY pagosemanal.nombre order by empleados.tipoPago, pagosemanal.nombre";


  if (!$result = $con->query($sql7)) {
     die('There was an error running the query [' . $db->error . ']');
 }

 
//$activeSheet->setCellValue('H'.$i ,);

 while ($row = $result->fetch_assoc()) {
    
    $sheet->setCellValue('A'.$nofila, $noconse);
    $sheet->setCellValue('B'.$nofila, $row['idempleado']);
    $sheet->setCellValue('C'.$nofila, $row['tipo']);
    $sheet->setCellValue('D'.$nofila, strtoupper($row['nombre']) ); 
    $sheet->setCellValue('E'.$nofila, $row['sueldo1'] );
    $sheet->setCellValue('F'.$nofila, $row['bon1']  );
    $sheet->setCellValue('G'.$nofila, $row['sueldo2'] );
    $sheet->setCellValue('H'.$nofila, $row['bon2']  );
    $sheet->setCellValue('I'.$nofila,  '=SUM(E'.$nofila.':H'.$nofila.')' );
    echo 'empleado no: '. $row['nombre']  . '';
    $nofila++;
    $noconse++;
}



$fileName = 'PAGO DEL '.$fecha1Dato1.' DE '.$mes1Dato1. ' AL ' .$fecha2Dato2.' DE '.$mes2Dato2.'.xlsx';
ob_clean();
$writer = new Xlsx($spreadsheet);
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'. $fileName.'"');
        header('Cache-Control: max-age=0');


$writer->save('php://output');
        

/**
 * FUNCIONES
 */



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


function insertarDatos2($sql6, $con){
    if (!$result = $con->query($sql6)) {
        die('There was an error running the query [' . $db->error . ']');
    }

    
    while ($row = $result->fetch_assoc()) {

        
        if( !is_null( $row['idempleado_prod'])  and !is_null($row['nombreempleado'])){
            
            
            
                $queryInsert = "INSERT INTO pagosemanal SET
                        idempleado = " .$row["idempleado_prod"]. ",
                        nombre = '" .$row["nombreempleado"]. " " .$row["apellidoempleado"]."',
                        sueldo1 =  0.0,
                        bon1 = 0.0 ,
                        sueldo2 = " .$row["SUM(importe)"]. ",
                        bon2 = " .(5 / 100) * $row["SUM(importe)"]. " ";
                $insert = mysqli_query($con,$queryInsert);
        }
    }    
}



function estilos($estilo){
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

    switch ($estilo) {
        case 'estiloArray':
            # code...
            return $styleArray;
            break;
        case 'centrar':
            # code...
            return $centrar;
            break;

        case 'bold':
            # code...
            return $bold;
            break;
        case 'relleno':
            # code...
            return $relleno;
            break;
        case 'fila':
            # code...
            return $rellenoFila;
            break;
        case 'columna':
            # code...
            return $rellenoColumn;
            break;

        
    }

}