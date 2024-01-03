<?php
$servername = "localhost";
$username = "root";
$password = "12345678";
$dbname = "produccion";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM resumen_tiros_generales_mes ORDER BY fecha_inicio_mes ASC";
$result = $conn->query($sql);

$datos = array();
// Añade las sumatorias interanuales al arreglo de datos
array_push($datos, array('Fecha', 'Sumatoria Tiros Generales Mes', 'Sumatoria Tiros Generales Interanual'));

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        // Añade la sumatoria interanual a cada fila
        array_push($datos, array($row["fecha_inicio_mes"], (int)$row["sumatoria_tiros_generales_mes"], (int)$row["sumatoria_interanual"]));
    }
} else {
    echo "0 results";
}
$conn->close();

$jsonTable = json_encode($datos);
?>
<html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable(<?php echo $jsonTable; ?>);

        var options = {
            title: 'Comparativa de Sumatoria de Tiros Generales',
            hAxis: {
                title: 'Fecha',
                titleTextStyle: {color: '#333'},
                slantedText: true,
                slantedTextAngle: 15,
                format: 'yyyy-MM' // Asegúrate que la fecha está en el formato correcto
            },
            vAxis: {
                title: 'Sumatoria Tiros Generales',
                minValue: 0
            },
            series: {
                0: {targetAxisIndex: 0},
                1: {targetAxisIndex: 1}
            },
            chartArea: {width: '80%', height: '70%'}
        };

        var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
  </head>
  <body>
    <div id="chart_div" style="width: 100%; height: 500px;"></div>
  </body>
</html>
