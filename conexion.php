<html>
    <head>
      <meta charset="utf-8">
    </head>

    <body>
<?php
/* Realiza la conexión a la base de datos,
 * solo hay que poner require 'conexion.php';
 * y jala este codigo y realiza la conexión.
 */
$hostname = 'localhost';
$database = 'sombrerosoficina';
$username = 'root';
$password = '';

try {
    $con = new PDO('mysql:host='.$hostname.';dbname='.$database, $username, $password);
    echo "<h1>Conexión exitosa!</h1>";
    echo "<br>";
}
catch (PDOException $e) {
    print "¡Error!: " . $e->getMessage() . "
";
    die();
}

?>

<body>

</html>

