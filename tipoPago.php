<?php
//session_start();

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
    tipoPago INT DEFAULT 0,
    activo smallint DEFAULT 1
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
    

    //Consulta que se utiliza para mostrar a los clientes
    $clientes="SELECT * FROM clientes WHERE activo = 1";
    $resClientes=$con->query($clientes);

    //Consulta para traer los registros que no estan registrado en la tabla
    $clientesnoRegistrados = "Select * from actualizacliente where not exists (select 1 from clientes where clientes.idempleado = actualizacliente.idempleado)";
    $resClientesNoRegistrados=$con->query($clientesnoRegistrados);


    $existe = "Select * from actualizacliente where not exists (select 1 from clientes where clientes.idempleado = actualizacliente.idempleado)";
    $resExiste=$con->query($existe);
    $row6=mysqli_fetch_row($resExiste);
    
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


?>
    <div style="text-align:center;">


        <form method="POST" action="procesaDatoPago.php">

            <?php
                
                while ($registroClientes = $resClientes->fetch_array(MYSQLI_BOTH))

                {

                    echo'<div style="display: flex; align-items: center; justify-content: center;">
                       
                    
                        <div  style=" height: 50px;  width:30px; " >
                            <input style="visibility:hidden;" name="idalu[]" value="'.$registroClientes['idempleado'].'" />
                        </div>


                        
                        
                        <div  style=" padding-right:30px;  ">
                            <input style=" height: 28px;" readOnly="readonly" name="idalu2['.$registroClientes['idempleado'].']" value="'.$registroClientes['idempleado'].'" />
                        </div>
                        
                        <div  style=" padding-right:30px;">
                            <input  style=" height: 28px;" readOnly="readonly" name="nom['.$registroClientes['idempleado'].']" value="'.$registroClientes['nombre'].'" />
                        </div >
                        
                        <select style=" height: 28px;" name="tipo['.$registroClientes['idempleado'].']">
                            <option value="0" ' . ($registroClientes['tipoPago']==0 ? 'selected ' : ''). '  >
                            --- Seleccione ---
                            </option>
                            
                            <option value="1" ' . ($registroClientes['tipoPago']==1 ? 'selected ' : ''). '>
                                Pago 1
                            </option>
                            
                            <option value="2" ' . ($registroClientes['tipoPago']==2 ? 'selected ' : ''). '>
                                Pago 2
                            </option>

                            <option value="3" ' . ($registroClientes['tipoPago']==3 ? 'selected ' : ''). '>
                                Pago 3
                            </option>
                        </select>

                       

                        <div  style=" padding-left:30px;">
                        <input type="hidden" name="activo['.$registroClientes['idempleado'].']" value="0">
                            <input  name="activo['.$registroClientes['idempleado'].']" type="checkbox" id="cbox2" value="1" checked> <label for="cbox2" id="textoh3">ACTIVO</label>
                        </div>

                        <br>
                    <br>
                </div>';
                }
            ?>
            <br>
            <!-- <button type="submit" class="btn btn-primary " style="margin-top: 10px ;">Guardar</button> -->
            <input type="submit" name="actualizar" value="Guardar" style='width:90px; height:35px' />
        </form>





        <form method="POST" action="procesaDatoPago.php">

            <?php
                
                if ( is_null($row6[0]) )
                    {
                    echo '<div>
                            <p id="textoh3">SIN DATOS NUEVOS</p>
                    </div>';
                    } else {
                        
                        echo "<div>
                        <p id= 'textoh3'>Datos a registrar </p>
                </div>";
                    }
                


                while ($registroClientes2 = $resClientesNoRegistrados->fetch_array(MYSQLI_BOTH))

                {

                    

                    echo'<div style="display: flex; align-items: center; justify-content: center;">
                       
                    
                        <div  style=" height: 50px;  width:30px; " >
                            <input style="visibility:hidden;" name="idalu2[]" value="'.$registroClientes2['idempleado'].'" />
                        </div>


                        
                        
                        <div  style=" padding-right:30px;  ">
                            <input style=" height: 28px;" readOnly="readonly" name="idalu3['.$registroClientes2['idempleado'].']" value="'.$registroClientes2['idempleado'].'" />
                        </div>
                        
                        <div  style=" padding-right:30px;">
                            <input  style=" height: 28px;" readOnly="readonly" name="nom2['.$registroClientes2['idempleado'].']" value="'.$registroClientes2['nombre'].'" />
                        </div >
                        
                        <select style=" height: 28px;" name="tipo2['.$registroClientes2['idempleado'].']">
                            <option value="0" ' . ($registroClientes2['tipoPago']==0 ? 'selected ' : ''). '  >
                            --- Seleccione ---
                            </option>
                            
                            <option value="1" ' . ($registroClientes2['tipoPago']==1 ? 'selected ' : ''). '>
                                Pago 1
                            </option>
                            
                            <option value="2" ' . ($registroClientes2['tipoPago']==2 ? 'selected ' : ''). '>
                                Pago 2
                            </option>

                            <option value="3" ' . ($registroClientes2['tipoPago']==3 ? 'selected ' : ''). '>
                                Pago 3
                            </option>
                        </select>

                       

                        <div  style=" padding-left:30px;">
                        <input type="hidden" name="activo2['.$registroClientes2['idempleado'].']" value="0">
                            <input  name="activo2['.$registroClientes2['idempleado'].']" type="checkbox" id="cbox2" value="1" checked> <label for="cbox2" id="textoh3">ACTIVO</label>
                        </div>

                        <br>
                    <br>
                </div>';
                }


                if ( is_null($row6[0]) )
                {
                echo '<div>
                        <p></p>
                </div>';
                } else {
                    
                    echo '<div>
                    <input type="submit" name="actualizar_datos" value="Guardar" style="width:90px; height:35px" />
                    </div>';
           
                }
                    
                    
            ?>
            <br>


        </form>


    </div>

    <br>
    <br>

</body>

</html>