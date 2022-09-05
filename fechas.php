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
            <li class='active'><a href='pruebaExcel.php'><span>Reportes</span></a></li>
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
    $fecha1 = $_POST['fecha1'];
    echo"<br>";
    $fecha2 = $_POST['fecha2'];
    echo"<br>";
    $fecha3 = $_POST['fecha3'];
    echo"<br>";
    $fecha4 = $_POST['fecha4'];
    //echo $example . " " . $example2;
}
?>
    <div style="text-align:center;">
        <form action="pruebaexcel.php" id="TablaFechas" method="POST" role="form">
            <table class="table table-responsive" style="margin: 0 auto;">


                <tr>

                    <td colspan="2" style="text-align:center;">
                        SEMANA 1
                    </td>
                </tr>

                <tr>

                    <td>
                        Fecha Inicial
                    </td>

                    <td>Fecha Final</td>
                </tr>

                <tr>
                    <td><input type="date" name="fecha1" id="input" class="form-control" required="required"
                            title="dd/mm/yyyy"></td>

                    <td><input type="date" name="fecha2" id="input" class="form-control" required="required"
                            title="dd/mm/yyyy"></td>
                </tr>




                <tr>

                    <td>

                    </td>

                </tr>



                <tr>
                    <br />

                    <td style="text-align:center;" colspan="2" class="h-75">
                        SEMANA 2
                    </td>

                </tr>

                <tr>


                    <td>
                        Fecha Inicial
                    </td>

                    <td>Fecha Final</td>
                </tr>


                <tr>
                    <td><input type="date" name="fecha3" id="input" class="form-control" required="required"
                            title="dd/mm/yyyy"></td>

                    <td><input type="date" name="fecha4" id="input" class="form-control" required="required"
                            title="dd/mm/yyyy"></td>
                </tr>





            </table>

            <br>

            <button type="submit" class="btn btn-primary ">Enviar</button>


        </form>
    </div>



    <br>
    <!-- el action no tiene nombre de archivo, para que se ejecute
aqui mismo -->




    <br>

</body>

</html>