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
  <script type='text/javascript'>
    $(function () {
      Highcharts.setOptions({});

      $('#container').highcharts({
        title: {
          text: 'Histograma'
        },
        xAxis: {
          title: {
            text: '[Potencia en Watts]' // Cambiar el título del eje X
          },
          type: 'linear', // Cambiar el tipo de eje a lineal
          tickPixelInterval: 100 // Ajustar la densidad de las marcas del eje
        },
        yAxis: {
          type: 'logarithmic', // Cambiar el tipo de eje a logarítmico
          title: {
            text: '[minutos]'
          },
          plotLines: [{
            value: 0,
            width: 1,
            color: '#808080'
          }]
        },
        tooltip: {
          formatter: function() {
            var timeValue = Highcharts.numberFormat(this.y, 1) ;
            var timeUnit = 'minutos';

            if (timeValue > 60) {
              timeValue = (timeValue / 60).toFixed(1);
              timeUnit = 'horas';

            }

            return '<b>' + this.series.name + '</b><br/>' +
              Highcharts.numberFormat(this.x, 1) + ' Watts' + '<br/>' +
              timeValue + ' ' + timeUnit;
          }
        },
        legend: {
          enabled: true
        },
        exporting: {
          enabled: true
        },
        series: [{
          name: 'Histograma',
          animation: false,
          data: <?php
            // Conexión a la base de datos
            $servername = "localhost";
            $username = "root";
            $password = "12345678";
            $dbname = "powermeter";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Error de conexión a la base de datos: " . $conn->connect_error);
            }

            // Consulta para obtener los datos del histograma
            $sql = "SELECT `potencia_w`, `minutos` FROM `histograma_inst_bt_a1` ORDER BY `histograma_inst_bt_a1`.`potencia_w` ASC ";
            $result = $conn->query($sql);

            // Crear el array de datos en formato para Highcharts
            $data = array();
            while ($row = $result->fetch_assoc()) {
                $data[] = array((float)$row["potencia_w"], (float)$row["minutos"] );
            }
            echo json_encode($data);

            // Cerrar conexión a la base de datos
            $conn->close();
          ?>
        }]
      });
    });
  </script>
  <header>
    <?php require 'header.php'; ?> 
  </header>
  <nav>
      <br>
      <br>
      <br>
      <br>
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
