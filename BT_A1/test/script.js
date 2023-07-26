google.charts.load('current', {'packages':['gauge']});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
  // Obtener la velocidad de la máquina desde tu fuente de datos
  var velocidad = 50;

  var velocidadData = google.visualization.arrayToDataTable([
    ['Label', 'Value'],
    ['Velocidad', velocidad]
  ]);

  var velocidadOptions = {
    width: 400,
    height: 400,
    redFrom: 0,
    redTo: 65,
    yellowFrom: 65,
    yellowTo: 85,
    greenFrom: 85,
    greenTo: 100,
    minorTicks: 6,
    max: 100,
    majorTicks: ['0', '25', '50', '75', '100']
  };

  var velocidadChart = new google.visualization.Gauge(document.getElementById('velocidad_chart_div'));
  velocidadChart.draw(velocidadData, velocidadOptions);

}