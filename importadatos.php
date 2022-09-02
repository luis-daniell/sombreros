<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="UTF-8">
    <title>Importa archivo de tableta</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/styles.css" media="all" >
    <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
    <script src="script.js"></script>
    <link  rel="shortcut icon" href="images/favicon.ico" />
</head>
<body id="main_body">


<!-- menu -->

<div id='cssmenu'>
    <ul>
        <li ><a href='index.html'><span>Inicio</span></a></li>
        <li class='active'><a href='importadatos.php'><span>Importar datos</span></a></li>
        <li><a href='fechas.php'><span>Reportes</span></a></li>
        <!-- <li class='last'><a href='#'><span>Contact</span></a></li> -->
    </ul>
</div>

<img id="top" src="top.png" alt="">
<div id="form_container">

    <h1><a>Importar trabajos a la base de datos</a></h1>
    <!-- formulario -->
    <form enctype="multipart/form-data" action="importa.php" method="POST">

        <div class="form_description">
            <h2>Importar trabajos a la base de datos</h2>
            <p>Selecciona el archivo enviado desde la tableta.<br>
                Solo haz este procedimiento una vez, o se duplicarán los datos.
                <br>
                Verifica que el archivo a subir sea el correcto!!</p>
        </div>


        <input type="hidden" name="MAX_FILE_SIZE" value="250000" />
        <label class="description" for="element_1">Selecciona el archivo </label>
        <br>
        <input name="archivo-a-subir" type="file" /><br>
        <br>
        <input  type="submit" value="Subir Archivo" />
    </form>


</div>

<?php
/*
    <!-- menu -->

<div id='cssmenu'>
    <ul>
        <li ><a href='index.html'><span>Inicio</span></a></li>
        <li class='active'><a href='importa.html'><span>Importar datos</span></a></li>
        <li><a href='reportes.html'><span>Reportes</span></a></li>
        <!-- <li class='last'><a href='#'><span>Contact</span></a></li> -->
    </ul>
</div>
<!-- formulario -->
<form enctype="multipart/form-data" action="importa.php" method="POST">
    <input type="hidden" name="MAX_FILE_SIZE" value="250000" />
    Elige el Archivo a Subir:
    <input name="archivo-a-subir" type="file" /><br>
    <input type="submit" value="Subir Archivo" />
</form>
<!-- El enctype=”multipart/form-data” sirve para especificar que nuestro formulario solicita
 datos binarios, el action=”subir-archivos.php” dice que cuando el usuario haga click
  sobre “Subir Archivo” iremos a esta pagina php en la cual manejaremos la subida
   (la veremos en un momento ), el input de tipo hidden mediante sus valores
    MAZ_FILE_SIZE especifica que únicamente aceptaremos archivos de máximo 250000 bytes (25Kb).

Mas Información en: http://jonathanmelgoza.com/blog/subida-de-archivos-en-php/#ixzz40avAxqyQ -->

</body>
*/


?>


</body>



</html>

