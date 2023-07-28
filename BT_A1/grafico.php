<script type='text/javascript'>    //Configuración y creación del gráfico potencia en función del tiempo
        $(function () {
            Highcharts.setOptions({
                global: { useUTC: false },
                lang:   { 
                    thousandsSep: "",
                    months: [ 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre' ],
                    weekdays: [ 'Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado' ]
                }
            });

            // Configuración y opciones del gráfico
            $('#container').highcharts({
                title: { text: (function() { return Highcharts.dateFormat("%A, %d %B %Y - %H:%M:%S", <?php echo 1000*$rawdata[0]["unixtime"]; ?>) })() },
                xAxis: { type: 'datetime', tickPixelInterval: 1 },
                yAxis: { title: { text: '[Watts]' },
                         plotLines: [ { value: 0, width: 1, color: '#808080' } ]
                },
                tooltip: { formatter: function() { return '<b>'+ this.series.name +'</b><br/>'+
                                                        Highcharts.dateFormat("%A, %d %B %Y - %H:%M:%S", this.x) +'<br/>'+
                                                        Highcharts.numberFormat(this.y, 1)+' Watts';
                                                }
                },
                legend: { enabled: true },
                exporting: { enabled: true },
                series: [ { name: 'Potencia maquina de bolsas',
                            animation: false,
                            data: (function() {
                                var data = [];
                                <?php 
                                for ($i = 0 ;$i  <count($rawdata);$i++) {
                                    $unixtime_v2 = $rawdata[$i]["unixtime"] * 1000 ;
                                    echo "data.push([ ".$unixtime_v2.",".$rawdata[$i]["potencia_III"] ."]);";
                                }
                                ?>
                                return data;
                            })()
                        }]
            });
        });

        
    </script>

<div id="container" class="graf"></div>

<br>
        <div class="form-container">
            <form action="index.php" method="GET">
                <?php if (isset($_GET['periodo'])) { echo "<input type='hidden' name='periodo' value=" . $_GET['periodo'] . ">";
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