<html>
    <head>
       <meta charset="UTF-8">
        <title>Importa datos de archivo</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/styles.css" media="all" >
        <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
        <script src="script.js"></script>
        <link  rel="shortcut icon" href="images/favicon.ico" />


    </head>

    <!-- menu -->

    <div id='cssmenu'>
        <ul>
            <li ><a href='index.html'><span>Inicio</span></a></li>
            <li class='active'><a href='importadatos.php'><span>Importar datos</span></a></li>
            <li><a href='fechas.php'><span>Reportes</span></a></li>
            <!-- <li class='last'><a href='#'><span>Contact</span></a></li> -->
        </ul>
    </div>

    <body>

<?php


//require 'conexion.php';

echo "<br>";
//echo "<p id='textoh1'>Aqui iria el selector de archivo</p>";
echo "<br>";

//Mas Información en: http://jonathanmelgoza.com/blog/subida-de-archivos-en-php/#ixzz40avVXnwy
$target_path = "C:/trabajossemanales/";
$target_path = $target_path . basename( $_FILES['archivo-a-subir']['name']);
$nombrearchivo = basename( $_FILES['archivo-a-subir']['name']);
if(move_uploaded_file($_FILES['archivo-a-subir']['tmp_name'], $target_path))
{
    echo " <p id='textoh2'>El archivo ". basename( $_FILES['archivo-a-subir']['name'])." ha sido subido exitosamente! </p>";
}
else
{
    echo "<p id='textoh2'> Hubo un error al subir tu archivo! Por favor intenta de nuevo.</p>";
}


/*
 *    PRUEBA 1 DE IMPORTACION
 *
 */
// to do el codigo funciona

//muestra como se llama el archivo
//echo "<br> El nombre del archivo es: ". $nombrearchivo;

//Conexion a la base de datos
$con=mysqli_connect("localhost","root","","sombrerosoficina");
// Check connection
if (mysqli_connect_errno())
{
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

function readCSV($csvFile){
    $file_handle = fopen($csvFile, 'r');
    while (!feof($file_handle) ) {
        $line_of_text[] = fgetcsv($file_handle, 1024);
    }
    fclose($file_handle);
    return $line_of_text;
}

// Set path to CSV file
//$csvFile = 'test_data.csv';
//$csvFile = 'contacts.csv';
$csvFile = "C:/trabajossemanales/" .$nombrearchivo;
//esta linea muestra donde se guardo el archivo
//echo "<br>" . $csvFile;

//calling the function
$csv = readCSV($csvFile);
if(!empty($csv)){
    foreach($csv as $file){
        //inserting into database
        $query_insert = "insert into produccion set
            idtableta    =    '".$file[0]."',
            fechaprod   =     '".$file[1]."',
            fechausu   =      '".$file[2]."',
            hora   =          '".$file[3]."',
            idempleado_prod   =   '".$file[4]."',
            nombreempleado   =   '".$file[5]."',
            apellidoempleado   =   '".$file[6]."',
            codtrabajo_prod   =   '".$file[7]."',
           cod_detalle_prod   =   '".$file[8]."',
            borrado  =   '".$file[9]."',
            cant   =   '".$file[10]."',
            descripciontrabajo   =   '".$file[11]."',
            descprod   =   '".$file[12]."',
            talla   =   '".$file[13]."',
            precioprod   =   '".$file[14]."',
            importe   =   '".$file[15]."',
            codpedido_prod  =   '".$file[16]."',
            obsprod =  '".$file[17]."'";



        //echo "la consulta es: " . $query_insert;
        $insert = mysqli_query($con,$query_insert);

    }
}else{
    echo 'Csv is empty';

}

echo "<br> <p id='textoh1'>Se han insertado los datos con éxito</p>";
echo "<br><br> <p id='textoh3'> Ahora puedes generar los reportes </p>"


?>


</body>

</html>

