<?php


    //Conexion a la base de datos 
    $con=mysqli_connect("localhost","root","","sombrerosoficina");
    // Check connection
    if (mysqli_connect_errno())
    {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    } 









    

//Revisa si existe produccion para traer a los empleados
    $sql = 'select * from produccion limit 1;';

    $result = mysqli_query($con, $sql);

    if($result == false)
    {
        echo("No existe produccion aun");
        exit();
    }

    //Revisa si existen registros
    $sql2 = "SELECT COUNT(*) AS total FROM produccion";
    $consulta = mysqli_query($con, $sql2);
    $row = mysqli_fetch_assoc($consulta);

    // comparamos con el alias total que dimos en la consulta
    if($row['total'] == '0'){
      // si no hay registros
      echo("No existen registros");
      exit();
    }














    

    

//Tabla para guardar los clientes y su tipo de pago
$sqlTabla = "CREATE TABLE IF NOT EXISTS clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    idempleado INT NOT NULL,
    nombre VARCHAR(255) NOT NULL,
    tipoPago INT DEFAULT 0
)";
$result = mysqli_query($con, $sqlTabla);





//Tabla para ver los clientes actualizados 
$borraT = "DROP TABLE IF EXISTS actualizaCliente";
$result = mysqli_query($con, $borraT);

$sqlTabla = "CREATE TABLE IF NOT EXISTS actualizaCliente (
    id INT AUTO_INCREMENT PRIMARY KEY,
    idempleado INT NOT NULL,
    nombre VARCHAR(255) NOT NULL,
    tipoPago INT DEFAULT 0
)";

$result = mysqli_query($con, $sqlTabla);










//Consulta para ver si existen registros en los tipos de pago 

  //Revisa si existen registros
  $sql3 = "SELECT COUNT(*) AS total FROM clientes";
  $cons = mysqli_query($con, $sql3);
  $row = mysqli_fetch_assoc($cons);


  
  // comparamos con el alias total que dimos en la consulta
  if($row['total'] == '0'){
    
    $agrupacion = "select idempleado_prod, nombreempleado, apellidoempleado from produccion GROUP by nombreempleado";

    if (!$result = $con->query($agrupacion)) {
        die('There was an error running the query [' . $db->error . ']');
    }



    while ($row = $result->fetch_assoc()) {

        $queryInsert = "INSERT INTO clientes SET
            idempleado = " .$row["idempleado_prod"]. ",
            nombre = '" .$row["nombreempleado"]. " " .$row["apellidoempleado"]."'
            ";
            
        $insert = mysqli_query($con,$queryInsert);
        
    }    
  }













  //Actualiza los clientes en caso de que se agrego uno nuevo 
  $agrupacion = "select idempleado_prod, nombreempleado, apellidoempleado from produccion GROUP by nombreempleado";

    if (!$result = $con->query($agrupacion)) {
        die('There was an error running the query [' . $db->error . ']');
    }



    while ($row = $result->fetch_assoc()) {

        $queryInsert = "INSERT INTO actualizaCliente SET
            idempleado = " .$row["idempleado_prod"]. ",
            nombre = '" .$row["nombreempleado"]. " " .$row["apellidoempleado"]."'
            ";
            
        $insert = mysqli_query($con,$queryInsert);
        
    } 


    $clientes="SELECT * FROM clientes";
    $resClientes=$con->query($clientes);



?>


<html>

<head>
    <meta charset="UTF-8">
    <title>Reportes</title>
    <!-- DATE PICKER DE:  http://jqueryui.com/datepicker/ -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="assets/css/main.css">
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <link rel="stylesheet" href="/resources/demos/style.css">
    <link rel="stylesheet" href="css/styles.css" media="all">
    <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
    <script src="script.js"></script>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="shortcut icon" href="images/favicon.ico" />
</head>

<body>

    <!-- menu -->

    <div id='cssmenu'>
        <ul>
            <li><a href='index.html'><span>Inicio</span></a></li>
            <li><a href='importadatos.php'><span>Importar datos</span></a></li>
            <li><a href='pruebaExcel.php'><span>Reportes</span></a></li>
            <li class='active'><a href='tipoPago.php'><span>Tipos de pago</span></a></li>
            <!-- <li class='last'><a href='#'><span>Contact</span></a></li> -->
        </ul>
    </div>

    <br><br><br>
    <p id="textoh1">Tipos de Pago</p>
    <br>
    <br>
    <p id="textoh3">Seleccione el tipo de pago para cada empleado</p>
    <br>
    <?php

    /*if (isset($_POST['generar'])) {
        
        $fecha1 = $_POST['fecha1'];
        echo"<br>";
        $fecha2 = $_POST['fecha2'];
        echo"<br>";
        $fecha3 = $_POST['fecha3'];
        echo"<br>";
        $fecha4 = $_POST['fecha4'];
        //echo $example . " " . $example2;
        //header('Location: fechas.php'); 
        
    }*/


?>
    <div style="text-align:center;">
        <form method="POST">






            <?php

                while ($registroClientes = $resClientes->fetch_array(MYSQLI_BOTH))

                {

                    echo'<tr>
                        <td hidden><input name="idalu[]" value="'.$registroClientes['idempleado'].'" /></td>
                        
                        <td><input name="idalu2['.$registroClientes['idempleado'].']" value="'.$registroClientes['idempleado'].'" /></td>
                        
                        <td><input name="nom['.$registroClientes['idempleado'].']" value="'.$registroClientes['nombre'].'" /></td>
                        
                        <td><input name="tipo['.$registroClientes['idempleado'].']" value="'.$registroClientes['tipoPago'].'" /></td>
                        <br>
                        <br>
                        </tr>';
                }


             ?>









            <!-- <button type="submit" class="btn btn-primary " style="margin-top: 10px ;">Guardar</button> -->
            <input type="submit" name="actualizar" value="Guardar" />


        </form>


        <?php

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
					echo "FUNCIONA!";
                    //header( "refresh:1; url=tipoPago.php" ); 
                   // header("location:tipoPago.php");
                  // parent.window.location.reload();
                   


                   // header('Location: tipoPago.php');

				}

				else
				{
					echo "NO FUNCIONA!";
				}
			}

		?>


    </div>



    <br>

    <br>

</body>

</html>