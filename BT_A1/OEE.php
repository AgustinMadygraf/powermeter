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
                <td>Es el tiempo durante el cual se planificó intencionalmente detener la producción del equipo para realizar tareas de mantenimiento, ajustes o cambios en la configuración.</td>
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
        </section>

        <section>
            <h1>Gráfico Circular y Subgráfico:</h1>
            <div id="chartContainer1" style="height: 300px; width: 50%; display: inline-block;"></div>
            <div id="chartContainer2" style="height: 300px; width: 50%; display: inline-block;"></div>
           </section>
  </main>
  <footer>
    <?php require "footer.php";?>
  </footer>

  <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
  <script>
    window.onload = function () {
      var chart1 = new CanvasJS.Chart("chartContainer1", {
        animationEnabled: true,
        title: {
          text: "T5 - Tiempo Calendario"
        },
        data: [{
          type: "pie",
          startAngle: 240,
          yValueFormatString: "##0.00\"%\"",
          indexLabel: "{label} {y}",
          dataPoints: [
            { y: 50, label: "T4 - Tiempo programado productivo" },
            { y: 20, label: "[T5-T4] Paro Programado" }
          ]
        }]
      });
      chart1.render();

      var chart2 = new CanvasJS.Chart("chartContainer2", {
        animationEnabled: true,
        title: {
          text: "T4 - Tiempo programado productivo"
        },
        data: [{
          type: "pie",
          startAngle: 240,
          yValueFormatString: "##0.00\"%\"",
          indexLabel: "{label} {y}",
          dataPoints: [
            { y: 60, label: "[T3] Tiempo operativo" },
            { y: 10, label: "[T4-T3] Paro no programado" }
          ]
        }]
      });
      chart2.render();
    }
  </script>
</body>
</html>
