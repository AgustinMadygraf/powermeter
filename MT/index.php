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
    include 'conn.php';
    $sql = "SELECT `unixtime` from MT ORDER BY unixtime DESC LIMIT 1";
    $rawdata = ejecutarConsulta($sql);
    $cont = $rawdata[0]["unixtime"];
    //echo "cont: ".$cont."<br>";



    $periodo = obtenerPeriodoSeleccionado();
    $conta = isset($_GET['conta']) ? intval($_GET['conta']) : $cont;

    $sql = "SELECT * FROM mt WHERE unixtime > " . ($conta - $periodo) . " AND unixtime <= " . $conta . " ORDER BY unixtime ASC";
    $rawdata = ejecutarConsulta($sql);
    //echo "conta: ".$conta."<br>";
    echo "sql: <br>".$sql."<br>";
    //echo "periodo: ".$periodo."<br>";
    echo 'rawdata[0]["unixtime"]: '.$rawdata[0]["unixtime"].'<br>';
    echo 'rawdata[0]["pot_III"]: '.$rawdata[0]["pot_III"].'<br>';
    echo 'rawdata[0]["pot_15"]: '.$rawdata[0]["pot_15"].'<br>';
    echo 'rawdata[0]["id"]: '.$rawdata[0]["id"].'<br>';
    ?>

    <div id="container" class="graf"></div>
    <script type='text/javascript'>
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
                                $pot_III = $rawdata[$i]["pot_III"];

                                if ($pot_III === null) {
                                    $pot_III = 0;
                                }

                                echo "data.push([" . $unixtime_v2 . ", " . $pot_III . "]);";
                            }
                            ?>

                        return data;
                    })()
                },{
                    name: 'Potencia contratada',
                    animation: false,
                    data: (function () {
                        var data = [];
                        <?php
                        for ($i = 0; $i < count($rawdata); $i++) {
                            $unixtime_v2 = $rawdata[$i]["unixtime"] * 1000;
                            echo "data.push([" . $unixtime_v2 . ", 300]);";
                        }
                        ?>
                        return data;
                    })()
                },{
                    name: 'Potencia promedio 15 minutos',
                    animation: false,
                    data: (function () {
                        var data = [];
                        <?php
                                for ($i = 0; $i < count($rawdata); $i++) {
                                    $unixtime_v2 = $rawdata[$i]["unixtime"] * 1000;
                                    $pot_III = $rawdata[$i]["pot_15"];

                                    if ($pot_III === null) {
                                        $pot_III = 0;
                                    }

                                    echo "data.push([" . $unixtime_v2 . ", " . $pot_III . "]);";
                                }
                                ?>

                        return data;
                    })()
                }]
            });
        });
    </script>
    <div class="form-container">
        <form action="index.php" method="GET">
            <?php
            if (isset($_GET['periodo'])) {
                echo "<input type='hidden' name='periodo' value=" . $_GET['periodo'] . ">";
            };
            if (isset($_GET['conta'])) {
                echo "<input type='hidden' name='conta' value=" . $_GET['conta'] . ">";
            }
            ?>
            <button type="submit" name="conta" value="<?php echo $conta - $periodo; ?>">Anterior</button>
            <input type="submit" name="periodo" value="hora">
            <input type="submit" name="periodo" value="dia">
            <input type="submit" name="periodo" value="semana">
            <button type="submit" name="conta" value="<?php echo $conta; ?>">Siguiente</button>
            <button type="submit" name="conta" value="<?php echo $conta; ?>">>></button>
        </form>
    </div>

    <a href="/mediciones/scada/">SCADA</a><br>
    <a href="/index2.php" target="_blank">AppServ</a>
</body>
</html>
