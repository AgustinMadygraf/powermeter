<!DOCTYPE html>
<html lang="en">
<head>
    <title>OEE</title>
    <!-- Librerías y estilos externos -->
    <script src="/script.js"></script>
    <script src="https://code.highcharts.com/modules/series-label.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="style.css">
</head>
<body>
  
  <header>
    <?php require 'header.php'; ?> 
  </header>
  <nav>
      <div id="container" class="graf"></div>
  </nav>
  <main>
        <section>
            <p> El objetivo es democratizar la información para que la toma de decisiones sea inteligente. 
            <br>La información es generada mediante el procesamiento automático de datos confiables y objetivos.
            <br> 
            <h1>Definiciones OEE</h1>
            <table>
              <tr>
                <th>Concepto</th>
                <th>Definición</th>
              </tr>
              <tr>
                <td>OEE (Overall Equipment Effectiveness)</td>
                <td>Es una medida de la eficiencia global del equipo que indica la efectividad en el uso del tiempo de producción y la calidad del producto. Se calcula como el producto de los tres factores: Disponibilidad, Rendimiento y Calidad.</td>
              </tr>
              <tr>
                <td>Tiempo Calendario</td>
                <td>Es el tiempo total transcurrido, que abarca todos los días del calendario, incluyendo fines de semana y días festivos. Es el tiempo desde el inicio hasta el final del período analizado.</td>
              </tr>
              <tr>
                <td>Tiempo Programado Productivo</td>
                <td>Es el tiempo programado para llevar a cabo actividades productivas, es decir, el tiempo durante el cual se esperaba que el equipo estuviera funcionando y produciendo de acuerdo con el plan de producción.</td>
              </tr>
              <tr>
                <td>Paro Programado</td>
                <td>Es el tiempo durante el cual se planificó intencionalmente detener la producción del equipo.</td>
              </tr>
              <tr>
                <td>Tiempo Operativo</td>
                <td>Es el tiempo real en el que el equipo estuvo operando y produciendo. Se calcula como el Tiempo Programado Productivo menos el tiempo de paros programados.</td>
              </tr>
              <tr>
                <td>Paro No Programado</td>
                <td>Es el tiempo no planificado durante el cual el equipo deja de producir debido a fallos o problemas inesperados, como averías, falta de materiales, etc.</td>
              </tr>
            </table>
            <br>
            <br>
            <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
            <div id="chart_div"></div>
            <script>
              google.charts.load('current', {'packages':['bar']});
              google.charts.setOnLoadCallback(drawChart);
              var TProgProd = 40;
              var ParoProg = 100 - TProgProd;
              var TOper = <?php echo $disp; ?>;
              var ParoNoProg = TProgProd - TOper;
              var TProdReal = 3;
              var TAfecVel = TOper - TProdReal;
              var TProdNeta = 2 ;
              var TAfecCal = TProdReal - TProdNeta;

              function drawChart() {
                var data = google.visualization.arrayToDataTable([
                  ['Tiempo [horas]' ,  ' Tiempo Programado productivo', 'Paro programado', 'Tiempo operativo', 'Paro no programado', 'Tasa de producción real', 'Afectación por velocidad de producción', 'Tasa de producción neta', 'Afectación por calidad'],
                  ['Tiempo Calendario'                  , TProgProd , ParoProg  , 0     , 0          , 0          , 0         , 0         , 0         ],
                  ['Tiempo Programado productivo'       , 0         , 0         , TOper , ParoNoProg , 0          , 0         , 0         , 0         ],
                  ['Tiempo Operativo'                   , 0         , 0         , TOper , 0          , 0          , 0         , 0         , 0         ],
                  ['Tasa de producción de diseño 100%'  , 0         , 0         , 0     , 0          , TProdReal  , TAfecVel  , 0         , 0         ],
                  ['Tasa de producción real'            , 0         , 0         , 0     , 0          , 0          , 0         , TProdNeta , TAfecCal  ],
                  ['Tasa de producción neta'            , 0         , 0         , 0     , 0          , 0          , 0         , TProdNeta , 0         ]
                ]);

                var options = { isStacked: true, 
                                height: 400,
                                chart: {  title:    'Disponibilidad',
                                          subtitle: 'Tiempo de funcionalidad del sistema',},
                                bars: 'horizontal', 
                                hAxis: {format: 'decimal'},
                                colors: ['#1b9e77' ] };

                var chart = new google.charts.Bar(document.getElementById('chart_div'));

                chart.draw(data, google.charts.Bar.convertOptions(options));

              }
            </script>
        </section>
  </main>
  <footer>
    <?php require "footer.php";?>
  </footer>
</body>
</html>
