<html>

<head>
    <meta charset="UTF-8">
    <title>Reportes</title>
    <!-- DATE PICKER DE:  http://jqueryui.com/datepicker/ -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script>
    $(function() {
        $("#datepicker").datepicker();
    });
    </script>

    <!-- EST ES DE: http://stackoverflow.com/questions/4332379/simple-datepicker-like-calendar -->
    <script type="text/javascript" src="http://services.iperfect.net/js/IP_generalLib.js"> </script>

</head>

<body>

    <h1>Reportes de trabajos realizados</h1>
    <br>
    <br>
    <p> Aquí se generarán los reportes de trabajos</p>
    <br>
    <?php
//todo: resetear variables de fecha, o poner validacion
//Se checa que el boton "generar" no se haya oprimido
//cuando se presiona el boton, se ejecuta el codigo
if (isset($_POST['generar'])) {
    $fecha1 = $_POST['date1'];
    echo"<br>";
    $fecha2 = $_POST['date2'];
    //echo $example . " " . $example2;
}
?>


    <br>
    <!-- el action no tiene nombre de archivo, para que se ejecute
aqui mismo -->
    <form action="" method="post">
        <p> selecciona la fecha inicial:</p>
        <!-- <p>Date: <input type="text" id="datepicker"></p> -->
        <input type="text" name="date1" id="date1" alt="date" class="IP_calendar" title="d/m/Y">
        <p> Selecciona la fecha final</p>
        <!-- <p>Date2 <input type="text" id="datepicker"></p> -->
        <input type="text" name="date2" id="date1" alt="date" class="IP_calendar" title="d/m/Y">
        <br>
        <input name="generar" type="submit">
        <br>
        <br>
    </form>

    <br>
    <br>
    <?php
    //Cambia de formato la fecha
    //Fecha inicial
    /* ejemplo
    $date = date_create_from_format('j-M-Y', '15-Feb-2009');
    echo "<br> nueva fecha : " . date_format($date, 'Y-m-d');
    echo "<br><br>";
    */

    echo "<br> La fecha inicial es: " . $fecha1;
    //$date = date_create_from_format('j-M-Y', '15-Feb-2009');
    $date1 = date_create_from_format('d/m/Y', $fecha1);
    echo "<br> nueva fecha inicial es : " . date_format($date1, 'Y-m-d');
    $fechaini = date_format($date1, 'Y-m-d');
    echo "la fechaIni es: " . $fechaini;

    echo "<br> <br>";
    echo "<br> La fecha Final es: " . $fecha2;
    //$date = date_create_from_format('j-M-Y', '15-Feb-2009');
    $date2 = date_create_from_format('d/m/Y', $fecha2);
    echo "<br> nueva fecha inicial es : " . date_format($date2, 'Y-m-d');
    $fechafin = date_format($date2, 'Y-m-d');



echo "<br> <br>";

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
        echo "id Máximo del empleado es : " . $row["MAX(idempleado_prod)"]."<br>";
        $idempleadoarray[] = $row['MAX(idempleado_prod)'];
    }
} else {
    echo "0 results";
}

echo "<br> el id Maximo del empleado desde aray es: ". $idempleadoarray[0];


/*
/// funciona pero es una sola
/////////////  TABLA DE PRODUCCION
//inicia tabla
//now output the data to a simple html table...
echo "<table border=1>";
echo "<tr>
            <td>id Tableta</td>
            <td>fecha produccion</td>
            <td>id empleado</td>
            <td>nombre</td>
            <td>apellido</td>
            <td>cant</td>
            <td>trabajo</td>
            <td>descripcion</td>
            <td>precio</td>
            <td>importe</td>
        </tr>";




$sql = <<<SQL
    SELECT *
    FROM `produccion`
SQL;

if(!$result = $con->query($sql)){
    die('There was an error running the query [' . $db->error . ']');
}

while($row = $result->fetch_assoc()){
    //echo $row['idtableta'] . '<br />';
    print "<tr><td>".$row['idtableta']."</td>";
    print "<td>".$row['fechaprod']."</td>";
    print "<td>".$row['idempleado_prod']."</td>";
    print "<td>".$row['nombreempleado']."</td>";
    print "<td>".$row['apellidoempleado']."</td>";
    print "<td>".$row['cant']."</td>";
    print "<td>".$row['descripciontrabajo']."</td>";
    print "<td>".$row['descprod']."</td>";
    print "<td>".$row['precioprod']."</td>";
    print "<td>".$row['importe']."</td>";


}

print "</table>";



echo "<br><br>linea final";

*/
//fin tabla unica de produccion


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


////  REPORTES POR EMPLEADOS

print "<BR><p>Comienzo de reportes por empleado</p>\n";
for ($id = 1 ; $id <= $idempleadoarray[0]; $id++) {
    //print "<p>$id</p>\n";

echo "<h2> No. empleado: " . $idemp[$id] . "   Nombre : " . $nombreemp[$id] . " " . $apellidoemp[$id] . "</h2>";

    //inicia tabla
//now output the data to a simple html table...
    echo "<table border=1>";
    echo "<tr>
            <td>id Tableta</td>
            <td>fecha produccion</td>
            <td>id empleado</td>
            <td>nombre</td>
            <td>apellido</td>
            <td>cant</td>
            <td>trabajo</td>
            <td>descripcion</td>
            <td>precio</td>
            <td>importe</td>
        </tr>";



/*
    $sql = <<<SQL
    SELECT *
    FROM `produccion` WHERE idempleado_prod =
SQL;
*/
    //conuslta generica con fechas
    // SELECT * FROM  produccion  WHERE idempleado_prod = 1 AND fechaprod >= "2016-01-01" AND fechaprod <= "2016-01-23"


    $sql3 = "SELECT * FROM  produccion  WHERE idempleado_prod = " . $id . " AND fechaprod >= '". $fechaini ."' and fechaprod <='" .$fechafin ."'" ;
    //echo $sql3 ;


    if(!$result = $con->query($sql3)){
        die('There was an error running the query [' . $db->error . ']');
    }

    while($row = $result->fetch_assoc()){
        //echo $row['idtableta'] . '<br />';
        print "<tr><td>".$row['idtableta']."</td>";
        print "<td>".$row['fechaprod']."</td>";
        print "<td>".$row['idempleado_prod']."</td>";
        print "<td>".$row['nombreempleado']."</td>";
        print "<td>".$row['apellidoempleado']."</td>";
        print "<td>".$row['cant']."</td>";
        print "<td>".$row['descripciontrabajo']."</td>";
        print "<td>".$row['descprod']."</td>";
        print "<td>".$row['precioprod']."</td>";
        print "<td>".$row['importe']."</td></tr>";
    }
    print "<td colspan=9 align=right> Total: </td>";
    print "<td>". $totalemp[$id] . "</td>";
    print "<tr>";
    print "</table>";
    echo "<br><br><br>";

}



/////////// LISTA DE RAYA
echo "<br><br><br>";
echo "<table border=1>";
echo "<tr>
            <td>No.</td>
            <td>Nombre</td>
            <td>Importe</td>
            <td>Firma</td>
        </tr>";

for ($id = 1 ; $id <= $idempleadoarray[0]; $id++) {
    print "<tr><td>" . $idemp[$id] . "</td>";
    print "<td>" . $nombreemp[$id] . " " .$apellidoemp[$id]. " </td>";
    print "<td>" . $totalemp[$id] . "</td>";
    print "<td>   </td>";

    }
print "</tr>";
print "</table>";
echo "<br><br><br>";





///// FIN LISTA DE RAYA
print "<p>Final</p>\n";

//cierra la base de datos
mysqli_close($con);

?>

</body>

</html>