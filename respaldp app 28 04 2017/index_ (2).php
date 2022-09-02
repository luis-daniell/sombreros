<html>
    <head>

    </head>

    <body>
       <h1>Codigo Basico de php</h1>

        <br>
        <br>
    </body>

</html>


<?php
require('fpdf.php');
    //conexion a la base de datos
    $conexion = new PDO('sqlite:C:\sombrerosDatabase\sombreros.db');

// ejemplo de tabla web

//inicia tabla
//now output the data to a simple html table...
echo "<table border=1>";
echo "<tr>
            <td>Nombre Empleado</td>
            <td>Breed</td>
            <td>Name</td>
            <td>Age</td>
        </tr>";


$result = $conexion->query('SELECT * FROM empleados');

//muestra tabla en pantalla

foreach($result as $row)
{
print "<tr><td>".$row['nombreempleado']."</td>";
print "<td>".$row['apellidoempleado']."</td>";
print "<td>".$row['obsempleado']."</td>";
print "<td>".$row['empleadoactivo']."</td></tr>";
}
print "</table>";
//termina tabla







?>