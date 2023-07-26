
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

    sql: <br>SELECT * FROM mt WHERE unixtime > 1626893260 AND unixtime <= 1626896860 ORDER BY unixtime ASC<br>rawdata[0]["unixtime"]: 1626893319<br>rawdata[0]["pot_III"]: 94.8<br>rawdata[0]["pot_15"]: 96.7<br>rawdata[0]["id"]: 204750<br>
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
                        return Highcharts.dateFormat("%A, %d %B %Y - %H:%M:%S", 1626893319000)
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
                                                    data.push([1626893319000, 94.8]);data.push([1626893380000, 97.3]);data.push([1626893439000, 95.5]);data.push([1626893500000, 93.9]);data.push([1626893561000, 93.7]);data.push([1626893619000, 95.1]);data.push([1626893680000, 95.1]);data.push([1626893739000, 95.3]);data.push([1626893800000, 96]);data.push([1626893861000, 96.2]);data.push([1626893920000, 95.5]);data.push([1626893980000, 98]);data.push([1626894039000, 97.9]);data.push([1626894100000, 96.5]);data.push([1626894159000, 96.8]);data.push([1626894220000, 95.4]);data.push([1626894279000, 95.3]);data.push([1626894340000, 95.2]);data.push([1626894400000, 92.9]);data.push([1626894459000, 93.6]);data.push([1626894520000, 93.9]);data.push([1626894579000, 92.8]);data.push([1626894640000, 88.7]);data.push([1626894699000, 88.8]);data.push([1626894760000, 89.6]);data.push([1626894821000, 88.6]);data.push([1626894879000, 89.6]);data.push([1626894940000, 90.9]);data.push([1626894999000, 90.6]);data.push([1626895060000, 91.4]);data.push([1626895121000, 93.7]);data.push([1626895179000, 93.2]);data.push([1626895240000, 92.6]);data.push([1626895299000, 90.8]);data.push([1626895360000, 91.1]);data.push([1626895419000, 90.6]);data.push([1626895480000, 90.5]);data.push([1626895541000, 88.6]);data.push([1626895599000, 89.2]);data.push([1626895660000, 88.6]);data.push([1626895719000, 89.9]);data.push([1626895780000, 90.5]);data.push([1626895839000, 89.8]);data.push([1626895900000, 89.2]);data.push([1626895960000, 89.2]);data.push([1626896019000, 89.7]);data.push([1626896080000, 90.1]);data.push([1626896139000, 89.7]);data.push([1626896200000, 89.1]);data.push([1626896260000, 88.5]);data.push([1626896319000, 87.9]);data.push([1626896380000, 88.3]);data.push([1626896439000, 89.6]);data.push([1626896500000, 90.7]);data.push([1626896560000, 89.9]);data.push([1626896619000, 89.5]);data.push([1626896680000, 88.6]);data.push([1626896739000, 88.6]);data.push([1626896800000, 87.5]);data.push([1626896860000, 89]);
                        return data;
                    })()
                },{
                    name: 'Potencia contratada',
                    animation: false,
                    data: (function () {
                        var data = [];
                        data.push([1626893319000, 300]);data.push([1626893380000, 300]);data.push([1626893439000, 300]);data.push([1626893500000, 300]);data.push([1626893561000, 300]);data.push([1626893619000, 300]);data.push([1626893680000, 300]);data.push([1626893739000, 300]);data.push([1626893800000, 300]);data.push([1626893861000, 300]);data.push([1626893920000, 300]);data.push([1626893980000, 300]);data.push([1626894039000, 300]);data.push([1626894100000, 300]);data.push([1626894159000, 300]);data.push([1626894220000, 300]);data.push([1626894279000, 300]);data.push([1626894340000, 300]);data.push([1626894400000, 300]);data.push([1626894459000, 300]);data.push([1626894520000, 300]);data.push([1626894579000, 300]);data.push([1626894640000, 300]);data.push([1626894699000, 300]);data.push([1626894760000, 300]);data.push([1626894821000, 300]);data.push([1626894879000, 300]);data.push([1626894940000, 300]);data.push([1626894999000, 300]);data.push([1626895060000, 300]);data.push([1626895121000, 300]);data.push([1626895179000, 300]);data.push([1626895240000, 300]);data.push([1626895299000, 300]);data.push([1626895360000, 300]);data.push([1626895419000, 300]);data.push([1626895480000, 300]);data.push([1626895541000, 300]);data.push([1626895599000, 300]);data.push([1626895660000, 300]);data.push([1626895719000, 300]);data.push([1626895780000, 300]);data.push([1626895839000, 300]);data.push([1626895900000, 300]);data.push([1626895960000, 300]);data.push([1626896019000, 300]);data.push([1626896080000, 300]);data.push([1626896139000, 300]);data.push([1626896200000, 300]);data.push([1626896260000, 300]);data.push([1626896319000, 300]);data.push([1626896380000, 300]);data.push([1626896439000, 300]);data.push([1626896500000, 300]);data.push([1626896560000, 300]);data.push([1626896619000, 300]);data.push([1626896680000, 300]);data.push([1626896739000, 300]);data.push([1626896800000, 300]);data.push([1626896860000, 300]);                        return data;
                    })()
                },{
                    name: 'Potencia promedio 15 minutos',
                    animation: false,
                    data: (function () {
                        var data = [];
                        data.push([1626893319000,96.7 ]);data.push([1626893380000,96.6 ]);data.push([1626893439000,96.7 ]);data.push([1626893500000,96.1 ]);data.push([1626893561000,95.6 ]);data.push([1626893619000,95.7 ]);data.push([1626893680000,95 ]);data.push([1626893739000,95.1 ]);data.push([1626893800000,95 ]);data.push([1626893861000,94.9 ]);data.push([1626893920000,95.3 ]);data.push([1626893980000,95.3 ]);data.push([1626894039000,95.7 ]);data.push([1626894100000,95.7 ]);data.push([1626894159000,95.8 ]);data.push([1626894220000,95.8 ]);data.push([1626894279000,95.9 ]);data.push([1626894340000,95.8 ]);data.push([1626894400000,95.8 ]);data.push([1626894459000,95.8 ]);data.push([1626894520000,95.6 ]);data.push([1626894579000,95.6 ]);data.push([1626894640000,95.2 ]);data.push([1626894699000,94.8 ]);data.push([1626894760000,94.3 ]);data.push([1626894821000,93.6 ]);data.push([1626894879000,93.4 ]);data.push([1626894940000,92.5 ]);data.push([1626894999000,92.5 ]);data.push([1626895060000,91.7 ]);data.push([1626895121000,91.4 ]);data.push([1626895179000,91.8 ]);data.push([1626895240000,91.6 ]);data.push([1626895299000,91.4 ]);data.push([1626895360000,91 ]);data.push([1626895419000,91.1 ]);data.push([1626895480000,90.8 ]);data.push([1626895541000,90.8 ]);data.push([1626895599000,90.9 ]);data.push([1626895660000,90.8 ]);data.push([1626895719000,90.9 ]);data.push([1626895780000,90.9 ]);data.push([1626895839000,90.9 ]);data.push([1626895900000,90.7 ]);data.push([1626895960000,90.7 ]);data.push([1626896019000,90.5 ]);data.push([1626896080000,89.9 ]);data.push([1626896139000,90 ]);data.push([1626896200000,89.7 ]);data.push([1626896260000,89.7 ]);data.push([1626896319000,89.5 ]);data.push([1626896380000,89.3 ]);data.push([1626896439000,89.4 ]);data.push([1626896500000,89.3 ]);data.push([1626896560000,89.5 ]);data.push([1626896619000,89.5 ]);data.push([1626896680000,89.4 ]);data.push([1626896739000,89.3 ]);data.push([1626896800000,89.1 ]);data.push([1626896860000,89.1 ]);                        return data;
                    })()
                }]
            });
        });
    </script>
    <div class="form-container">
        <form action="index.php" method="GET">
            <input type='hidden' name='periodo' value=hora><input type='hidden' name='conta' value=1626896860>            <button type="submit" name="conta" value="1626893260">Anterior</button>
            <input type="submit" name="periodo" value="hora">
            <input type="submit" name="periodo" value="dia">
            <input type="submit" name="periodo" value="semana">
            <button type="submit" name="conta" value="1626896860">Siguiente</button>
            <button type="submit" name="conta" value="1626896860">>></button>
        </form>
    </div>

    <a href="/mediciones/scada/">SCADA</a><br>
    <a href="/index2.php" target="_blank">AppServ</a>
</body>
</html>
