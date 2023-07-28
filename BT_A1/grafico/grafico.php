<!DOCTYPE html>
<html>
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/series-label.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>

    <?php
    include 'conn2.php';
    $sql = "SELECT `unixtime` from inst_bt_a1 ORDER BY unixtime DESC LIMIT 1";
    $rawdata = ejecutarConsulta($sql);
    $cont = $rawdata[0]["unixtime"];
    //echo "cont: ".$cont."<br>";



    $periodo = obtenerPeriodoSeleccionado();
    $conta = isset($_GET['conta']) ? intval($_GET['conta']) : $cont;

    $sql = "SELECT * FROM inst_bt_a1 WHERE unixtime > " . ($conta - $periodo) . " AND unixtime <= " . $conta . " ORDER BY unixtime ASC";
    $rawdata = ejecutarConsulta($sql);

    echo "sql: <br>".$sql."<br>";

    echo 'rawdata[0]["unixtime"]: '.$rawdata[0]["unixtime"].'<br>';
    echo 'rawdata[0]["potencia_III"]: '.$rawdata[0]["potencia_III"].'<br>';
    echo 'rawdata[0]["id"]: '.$rawdata[0]["id"].'<br>';
    ?>

    <div id="container" class="graf"></div>
    <script type='text/javascript'>
        // Función para actualizar el gráfico con nuevos datos
        function actualizarGrafico(periodo) {
            var conta = <?php echo $cont; ?>;
            if (periodo === 'hora') {
                conta -= 3600;
            } else if (periodo === 'dia') {
                conta -= 86400;
            } else if (periodo === 'semana') {
                conta -= 604800;
            }
            // Realizar la petición AJAX al servidor para obtener los nuevos datos
            $.ajax({
                url: 'datos.php', // Ruta del script que devuelve los datos
                type: 'GET',
                data: { conta: conta },
                dataType: 'json',
                success: function (data) {
                    // Actualizar el gráfico con los nuevos datos
                    var chart = $('#container').highcharts();
                    chart.series[0].setData(data);
                },
                error: function (xhr, status, error) {
                    console.log('Error al obtener los datos: ' + error);
                }
            });
        }

        $(function () {
            Highcharts.setOptions({
                global: {
                    useUTC: false
                },
                lang: {
                    thousandsSep: "",
                    months: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                    weekdays: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado']
                }
            });

            $('#container').highcharts({
                title: {
                    text: (function () {
                        return Highcharts.dateFormat("%A, %d %B %Y - %H:%M:%S", <?php echo 1000 * $rawdata[0]["unixtime"]; ?>)
                    })()
                },
                xAxis: {
                    type: 'datetime',
                    tickPixelInterval: 1
                },
                yAxis: {
                    title: {
                        text: '[KiloWatts]'
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
                            Highcharts.dateFormat("%A, %d %B %Y - %H:%M:%S", this.x) + '<br/>' +
                            Highcharts.numberFormat(this.y, 1) + ' kW';
                    }
                },
                legend: {
                    enabled: true
                },
                exporting: {
                    enabled: true
                },
                series: [{
                    name: 'Potencia instantanea',
                    animation: false,
                    data: (function () {
                        var data = [];
                                                    <?php
                            for ($i = 0; $i < count($rawdata); $i++) {
                                $unixtime_v2 = $rawdata[$i]["unixtime"] * 1000;
                                $pot_III = $rawdata[$i]["potencia_III"];

                                if ($pot_III === null) {
                                    $pot_III = 0;
                                }

                                echo "data.push([" . $unixtime_v2 . ", " . $pot_III . "]);";
                            }
                            ?>

                        return data;
                    })()
                },]
            });
        });

         // Evento para el botón de "Siguiente"
         $('#btn-siguiente').on('click', function (e) {
                e.preventDefault();
                actualizarGrafico('semana');
            });
        ;
    </script>
    <div class="form-container">

        <button id="btn-anterior">Anterior</button>
        <input type="button" name="periodo" value="hora">
        <input type="button" name="periodo" value="dia">
        <input type="button" name="periodo" value="semana">
        <button id="btn-siguiente">Siguiente</button>
    </div>
    </div>


</body>
</html>
