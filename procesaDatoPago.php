<?php


 //Conexion a la base de datos 
 $con=mysqli_connect("localhost","root","","sombrerosoficina");
 // Check connection
 if (mysqli_connect_errno())
 {
     echo "Failed to connect to MySQL: " . mysqli_connect_error();
 } 



if(isset($_POST['actualizar']))
{
    foreach ($_POST['idalu'] as $ids) 
    {
        $id=mysqli_real_escape_string($con, $_POST['idalu2'][$ids]);
        $editPago=mysqli_real_escape_string($con, $_POST['tipo'][$ids]);

        $activo=mysqli_real_escape_string($con, $_POST['activo'][$ids]);


        $actualizar=$con->query("UPDATE empleados SET tipoPago='$editPago', activo = $activo
                                                             WHERE idempleado='$id'");
    }

    if($actualizar==true)
    {
        
        header('Location: index.html');

    }

    else
    {
        echo "NO FUNCIONA!";
    }
}



if(isset($_POST['actualizar_datos']))
{
    foreach ($_POST['idalu2'] as $ids) 
    {
        $id2=mysqli_real_escape_string($con, $_POST['idalu3'][$ids]);
        $editPago2=mysqli_real_escape_string($con, $_POST['tipo2'][$ids]);
        $nombre2=mysqli_real_escape_string($con, $_POST['nom2'][$ids]);

        $activo2=mysqli_real_escape_string($con, $_POST['activo2'][$ids]);

        //Syntax
        //INSERT INTO table_name (column1, column2, column3, ...)
        //VALUES (value1, value2, value3, ...);
        $actualizar2=$con->query("INSERT INTO empleados (idempleado, nombre, tipoPago, activo) VALUES($id2, '$nombre2', $editPago2, $activo2 ) ");
    }

    if($actualizar2==true)
    {
        
        header('Location: index.html');

    }

    else
    {
        echo "NO FUNCIONA!";
    }
}



?>