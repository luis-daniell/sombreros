<?php
/**
 * Created by PhpStorm.
 * User: jesus
 * Date: 17/02/2016
 * Time: 00:19
 */

function conexion($host,$dbname,$user, $password)
{
    try {
        $con = new PDO('mysql:host='.$host.';dbname='.$dbname, $user, $password);
        print "Conexión exitosa!";
    }
    catch (PDOException $e) {
        print "¡Error!: " . $e->getMessage() . "
";
        die();
    }

}


function creabasedatos($host, $root, $root_password, $user, $pass, $dbnombre)
{

    try {
        $dbh = new PDO("mysql:host=$host", $root, $root_password);

        $dbh->exec("CREATE DATABASE `$dbnombre`;
                CREATE USER '$user'@'localhost' IDENTIFIED BY '$pass';
                GRANT ALL ON `$dbnombre`.* TO '$user'@'localhost';
                FLUSH PRIVILEGES;")
        or die(print_r($dbh->errorInfo(), true));
        echo " La Base de datos se ha creado exitosamente";

    } catch (PDOException $e) {
        die("DB ERROR: " . $e->getMessage());
    }
}




?>