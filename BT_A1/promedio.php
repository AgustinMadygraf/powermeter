<!DOCTYPE html>
<html>
<head>
    <title>Potencia eléctrica</title>
    <!-- Librerías y estilos externos -->
    <script src="/script.js"></script>
    <script src="https://code.highcharts.com/modules/series-label.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script src="script.js"></script>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php 
  
$servername = "localhost";
$username = "root";
$password = "12345678";
$dbname = "powermeter";

date_default_timezone_set('America/Argentina/Buenos_Aires');

// Función para conectar a la base de datos
function conectarBD()  {
    global $servername, $username, $password, $dbname;
    $conexion = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conexion) {
        die('Ha sucedido un error inesperado en la conexión de la base de datos<br>');}
    return $conexion; 
}

// Función para desconectar de la base de datos
function desconectarBD($conexion) {
    $close = mysqli_close($conexion);
    if (!$close) {
        die('Ha sucedido un error inesperado en la desconexion de la base de datos<br>'); }
    return $close;
}

// Función para obtener un array con el resultado de la consulta SQL
function getArraySQL($sql) {
    $conexion = conectarBD();
    if (!$result = mysqli_query($conexion, $sql)) {
        die(); }
    $rawdata = array();
    $i = 0;
    while ($row = mysqli_fetch_array($result)) {
        $rawdata[$i] = $row;
        $i++; }
    desconectarBD($conexion);
    return $rawdata;
}

$sql = "SELECT `hora`, `pot_prom` FROM `promedio` where `dia` = 1 ORDER BY `promedio`.`hora` ASC";
$rawdata_domingo = getArraySQL($sql);

$sql = "SELECT `hora`, `pot_prom` FROM `promedio` where `dia` = 2 ORDER BY `promedio`.`hora` ASC";
$rawdata_lunes = getArraySQL($sql);

$sql = "SELECT `hora`, `pot_prom` FROM `promedio` where `dia` = 3 ORDER BY `promedio`.`hora` ASC";
$rawdata_martes = getArraySQL($sql);

$sql = "SELECT `hora`, `pot_prom` FROM `promedio` where `dia` = 4 ORDER BY `promedio`.`hora` ASC";
$rawdata_miercoles = getArraySQL($sql);

$sql = "SELECT `hora`, `pot_prom` FROM `promedio` where `dia` = 5 ORDER BY `promedio`.`hora` ASC";
$rawdata_jueves = getArraySQL($sql);

$sql = "SELECT `hora`, `pot_prom` FROM `promedio` where `dia` = 6 ORDER BY `promedio`.`hora` ASC";
$rawdata_viernes = getArraySQL($sql);

$sql = "SELECT `hora`, `pot_prom` FROM `promedio` where `dia` = 7 ORDER BY `promedio`.`hora` ASC";
$rawdata_sabado = getArraySQL($sql);



; ?>    <!-- Gráficos -->     

<script type='text/javascript'>
    //Configuración y creación del gráfico potencia en función del tiempo
    $(function () {
        Highcharts.setOptions({
            global: { useUTC: false },
            lang: {
                thousandsSep: "",
                months: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                weekdays: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado']
            }
        });

        // Configuración y opciones del gráfico
        $('#container').highcharts({
            title: {
                text: 'Gráfico de Potencia por día',
            },
            xAxis: {
                type: 'datetime',
                tickPixelInterval: 1,
                labels: {
                    formatter: function () {
                        return Highcharts.dateFormat('%H:%M:%S', this.value);
                    }
                }
            },
            yAxis: {
                title: {
                    text: '[Watts]'
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            tooltip: {
                formatter: function () {
                    return '<b>' + this.series.name + '</b><br/>' +
                        Highcharts.dateFormat('%H:%M:%S', this.x) + '<br/>' +
                        Highcharts.numberFormat(this.y, 1) + ' Watts';
                }
            },
            legend: {
                enabled: true
            },
            exporting: {
                enabled: true
            },
            series: [{
                name: 'Domingo',
                animation: false,
                data: (function () {
                    var data = [];
                    <?php
                    foreach ($rawdata_domingo as $row) {
                        $hora = $row['hora'];
                        $potencia = $row['pot_prom'];
                        $timestamp = strtotime($hora);
                        $unixtime_v2 = $timestamp * 1000;
                        echo "data.push([" . $unixtime_v2 . "," . $potencia . "]);";
                    }
                    ?>
                    return data;
                })()
            },
            {
                name: 'Lunes',
                animation: false,
                data: (function () {
                    var data = [];
                    <?php
                    foreach ($rawdata_lunes as $row) {
                        $hora = $row['hora'];
                        $potencia = $row['pot_prom'];
                        $timestamp = strtotime($hora);
                        $unixtime_v2 = $timestamp * 1000;
                        echo "data.push([" . $unixtime_v2 . "," . $potencia . "]);";
                    }
                    ?>
                    return data;
                })()
            },
            {
                name: 'Martes',
                animation: false,
                data: (function () {
                    var data = [];
                    <?php
                    foreach ($rawdata_martes as $row) {
                        $hora = $row['hora'];
                        $potencia = $row['pot_prom'];
                        $timestamp = strtotime($hora);
                        $unixtime_v2 = $timestamp * 1000;
                        echo "data.push([" . $unixtime_v2 . "," . $potencia . "]);";
                    }
                    ?>
                    return data;
                })()
            },
            {
                name: 'Miércoles',
                animation: false,
                data: (function () {
                    var data = [];
                    <?php
                    foreach ($rawdata_miercoles as $row) {
                        $hora = $row['hora'];
                        $potencia = $row['pot_prom'];
                        $timestamp = strtotime($hora);
                        $unixtime_v2 = $timestamp * 1000;
                        echo "data.push([" . $unixtime_v2 . "," . $potencia . "]);";
                    }
                    ?>
                    return data;
                })()
            },
            {
                name: 'Jueves',
                animation: false,
                data: (function () {
                    var data = [];
                    <?php
                    foreach ($rawdata_jueves as $row) {
                        $hora = $row['hora'];
                        $potencia = $row['pot_prom'];
                        $timestamp = strtotime($hora);
                        $unixtime_v2 = $timestamp * 1000;
                        echo "data.push([" . $unixtime_v2 . "," . $potencia . "]);";
                    }
                    ?>
                    return data;
                })()
            },
            {
                name: 'Viernes',
                animation: false,
                data: (function () {
                    var data = [];
                    <?php
                    foreach ($rawdata_viernes as $row) {
                        $hora = $row['hora'];
                        $potencia = $row['pot_prom'];
                        $timestamp = strtotime($hora);
                        $unixtime_v2 = $timestamp * 1000;
                        echo "data.push([" . $unixtime_v2 . "," . $potencia . "]);";
                    }
                    ?>
                    return data;
                })()
            },
            {
                name: 'Sabado',
                animation: false,
                data: (function () {
                    var data = [];
                    <?php
                    foreach ($rawdata_sabado as $row) {
                        $hora = $row['hora'];
                        $potencia = $row['pot_prom'];
                        $timestamp = strtotime($hora);
                        $unixtime_v2 = $timestamp * 1000;
                        echo "data.push([" . $unixtime_v2 . "," . $potencia . "]);";
                    }
                    ?>
                    return data;
                })()
            },
            {
                name: 'limite 1',
                animation: false,
                data: (function () {
                    var data = [];
                    <?php
                    foreach ($rawdata_sabado as $row) {
                        $hora = $row['hora'];
                        $potencia = 420;
                        $timestamp = strtotime($hora);
                        $unixtime_v2 = $timestamp * 1000;
                        echo "data.push([" . $unixtime_v2 . "," . $potencia . "]);";
                    }
                    ?>
                    return data;
                })()
            },
            {
                name: 'limite 1',
                animation: false,
                data: (function () {
                    var data = [];
                    <?php
                    foreach ($rawdata_sabado as $row) {
                        $hora = $row['hora'];
                        $potencia = 560;
                        $timestamp = strtotime($hora);
                        $unixtime_v2 = $timestamp * 1000;
                        echo "data.push([" . $unixtime_v2 . "," . $potencia . "]);";
                    }
                    ?>
                    return data;
                })()
            }]
        });
    });
</script>


  <header>
    <?php require 'header.php'; ?> 
  </header>
  <nav>
    <br><br><br>
    <div id="container" class="graf"></div>
  </nav>
  <main>
        <section>
            <p> El objetivo es democratizar la información para que la toma de decisiones sea inteligente. 
            <br>La información es generada mediante el procesamiento automático de datos confiables y objetivos.
            <br> 
            </p>
            
            
        </section>

        
  </main>
  <footer>
    <?php require "footer.php";?>
  </footer>
</body>
</html>
