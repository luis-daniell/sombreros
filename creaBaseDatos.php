<?php
/**
 * Created by PhpStorm.
 * User: jesus
 * Date: 17/02/2016
 * Time: 00:58
 */

require 'databaseHelp.php';



$host="localhost";

$root="root";
$root_password="";

$user='newuser';
$pass='newpass';
$dbnombre="sombrerosoficina4";

//crea la base de datos
creabasedatos($host,$root,$root_password,$user,$pass,$dbnombre);

echo "<br";

//conexion a la bse de datos
conexion($host, $dbnombre,$root,$root_password);





?>