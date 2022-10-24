<?php

////////////////// CONEXION A LA BASE DE DATOS ////////////////////////////////////

$host="localhost";
$usuario="root";
$contraseña="root";
$base="itic";

$conexion= new mysqli($host, $usuario, $contraseña, $base);
if ($conexion -> connect_errno)
{
	die("Fallo la conexion:(".$conexion -> mysqli_connect_errno().")".$conexion-> mysqli_connect_error());
}

/////////////////////// CONSULTA A LA BASE DE DATOS ////////////////////////

$alumnos="SELECT * FROM alumnos";
$resAlumnos=$conexion->query($alumnos);
?>

<html lang="es">

	<head>
		<title>Actualizar Registros PHP</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>

		<link href="css/estilos.css" rel="stylesheet">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

	</head>

	<body>
		<header>
			<div class="alert alert-info">
			<h2>Actualizar Registros de la BD con PHP</h2>
			</div>
		</header>

		<section>
			<form method="post">
			<table class="table">

				<tr>
					<th>ID_Alumno</th>
					<th>Nombre</th>
					<th>Carrera</th>
					<th>Grupo</th>
				</tr>

				<?php

				while ($registroAlumnos = $resAlumnos->fetch_array(MYSQLI_BOTH))

				{

					echo'<tr>

						<td hidden><input name="idalu[]" value="'.$registroAlumnos['id_alumno'].'" /></td>

						 <td><input name="idalu2['.$registroAlumnos['id_alumno'].']" value="'.$registroAlumnos['id_alumno'].'" /></td>
						 <td><input name="nom['.$registroAlumnos['id_alumno'].']" value="'.$registroAlumnos['nombre'].'" /></td>
						 <td><input name="carr['.$registroAlumnos['id_alumno'].']" value="'.$registroAlumnos['carrera'].'" /></td>
						 <td><input name="gru['.$registroAlumnos['id_alumno'].']" value="'.$registroAlumnos['grupo'].'"/></td>
						 </tr>';
				}


				?>

			</table>
			<input type="submit" name="actualizar" value="Actualizar Registros" class="btn btn-info col-md-offset-9" />
		</form>

		<?php

			if(isset($_POST['actualizar']))
			{
				foreach ($_POST['idalu'] as $ids) 
				{
					$editID=mysqli_real_escape_string($conexion, $_POST['idalu2'][$ids]);
					$editNom=mysqli_real_escape_string($conexion, $_POST['nom'][$ids]);
					$editCarr=mysqli_real_escape_string($conexion, $_POST['carr'][$ids]);
					$editGru=mysqli_real_escape_string($conexion, $_POST['gru'][$ids]);

					$actualizar=$conexion->query("UPDATE alumnos SET id_alumno='$editID', nombre='$editNom', carrera='$editCarr',
																		grupo='$editGru' WHERE id_alumno='$ids'");
				}

				if($actualizar==true)
				{
					echo "FUNCIONA! <a href='actualizar_registros.php'>CLICK AQUÍ</a>";
				}

				else
				{
					echo "NO FUNIONA!";
				}
			}

		?>



		</section>

		<footer>
		</footer>
	</body>

</html>


