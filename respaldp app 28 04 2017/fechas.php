<html>
<head>
    <meta charset="UTF-8">
    <title>Reportes</title>
    <!-- DATE PICKER DE:  http://jqueryui.com/datepicker/ -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script>
        $(function() {
            $( "#datepicker" ).datepicker();
        });
    </script>

    <!-- EST ES DE: http://stackoverflow.com/questions/4332379/simple-datepicker-like-calendar -->
    <script type="text/javascript" src="http://services.iperfect.net/js/IP_generalLib.js"> </script>


    <link rel="stylesheet" href="css/styles.css" media="all" >
    <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
    <script src="script.js"></script>
    <link rel="stylesheet" href="css/styles.css">
    <link  rel="shortcut icon" href="images/favicon.ico" />
</head>

<body>

<!-- menu -->

<div id='cssmenu'>
    <ul>
        <li ><a href='index.html'><span>Inicio</span></a></li>
        <li ><a href='importadatos.php'><span>Importar datos</span></a></li>
        <li class='active'><a href='fechas.php'><span>Reportes</span></a></li>
        <!-- <li class='last'><a href='#'><span>Contact</span></a></li> -->
    </ul>
</div>




<br><br><br>
<p id="textoh1">Reportes de trabajos realizados</p>
<br>
<br>
<p id="textoh3">Para generar los reportes, selecciona las fechas</p>
<br>
<?php
//todo: resetear variables de fecha, o poner validacion
//Se checa que el boton "generar" no se haya oprimido
//cuando se presiona el boton, se ejecuta el codigo
if (isset($_POST['generar'])) {
    $fecha1 = $_POST['date1'];
    echo"<br>";
    $fecha2 = $_POST['date2'];
    //echo $example . " " . $example2;
}
?>


<br>
<!-- el action no tiene nombre de archivo, para que se ejecute
aqui mismo -->
<form action="pdfs.php" method="post" target="_blank">
    <p id="textoh3"> selecciona la fecha inicial:</p>
    <!-- <p>Date: <input type="text" id="datepicker"></p> -->
    <input type="text" name="date1" id="date1" alt="date" class="IP_calendar" title="d/m/Y">
    <p id="textoh3"> Selecciona la fecha final:</p>
    <!-- <p>Date2 <input type="text" id="datepicker"></p> -->
    <input type="text" name="date2" id="date1" alt="date" class="IP_calendar" title="d/m/Y">
    <br><br>
    <input name="generar" type="submit">
    <br>
    <br>
</form>

<br>

</body>
</html>

