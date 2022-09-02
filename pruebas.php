<?php

//conexion a la base de datos
$conexion = new PDO('sqlite:C:\sombrerosDatabase\sombreros.db');

//consulta
$result = $conexion->query('SELECT * FROM empleados');

$filas = $conexion->query('select count(*) from empleados');

//variables
$a = 7;


//cuantas filas tiene la consulta
$count = $conexion->exec("select count(*) from empleados");

//$numerofilas = $row = mysql_fetch_row($result);

//$filassqlite = sqlite_num_rows($result);

$numerofilas = $count->fetchColumn();


$query = "SELECT * FROM empleados ";
$result2 = $conexion->query($query) or die("Error in query: <span style='color:red;'>$query</span>");
//$num_columns =  $result->numColumns();


$hostname = 'localhost';
$database = 'sombrerosoficina';
$username = 'jesus';
$password = '123';

//require_once 'mysql-login.php';
try {
    $con = new PDO('mysql:host='.$hostname.';dbname='.$database, $username, $password);
    print "Conexión exitosa!";
}
catch (PDOException $e) {
    print "¡Error!: " . $e->getMessage() . "
";
    die();
}

$sql = "SELECT count(*) FROM usuarios";
$result = $con->prepare($sql);
$result->execute();
$number_of_rows = $result->fetchColumn();

echo "<br>";
print $a;
print "<br>";
echo "el numero de lines es: " . $number_of_rows;
echo "<br>";
echo" el numero de lineas en sqlite es: " . $numerofilas;


$con =null;

?>