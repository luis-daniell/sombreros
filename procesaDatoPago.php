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
        //$editCarr=mysqli_real_escape_string($conexion, $_POST['carr'][$ids]);
        //$editGru=mysqli_real_escape_string($conexion, $_POST['gru'][$ids]);

        $actualizar=$con->query("UPDATE clientes SET tipoPago='$editPago'
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

?>