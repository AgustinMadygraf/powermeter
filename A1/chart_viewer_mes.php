<script> //Configuración y creación del gráfico Disponibilidad 
        google.charts.load('current', {'packages':['gauge']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
        // Obtener la Disponibilidad de la máquina desde tu fuente de datos
        var Disponibilidad = <?php echo number_format($disp_mes*7.2,2);?>;
        var tamaño = 350;

        var DisponibilidadData = google.visualization.arrayToDataTable([
            ['Label', 'Value'],
            ['horas/mes', Disponibilidad]
        ]);

        var DisponibilidadOptions = {
            width:      tamaño,
            height:     tamaño,
            redFrom:    0,
            redTo:      250,
            yellowFrom: 250,
            yellowTo:   400,
            greenFrom:  400,
            greenTo:    720,
            minorTicks: 6,
            max:        720,
            majorTicks: ['0', '120', '240', '360', '480', '600', '720']
        };

        var DisponibilidadChart = new google.visualization.Gauge(document.getElementById('Disponibilidad_chart_mes'));
        DisponibilidadChart.draw(DisponibilidadData, DisponibilidadOptions); }
    </script>
    <td colspan="2"><div id="Disponibilidad_chart_mes"></div></td>
    