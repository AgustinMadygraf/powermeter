<script> //Configuración y creación del gráfico Disponibilidad 
        google.charts.load('current', {'packages':['gauge']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
        // Obtener la Disponibilidad de la máquina desde tu fuente de datos
        var Disponibilidad = <?php echo number_format($disp_turno*0.08,2);?>;
        var tamaño = 350;

        var DisponibilidadData = google.visualization.arrayToDataTable([
            ['Label', 'Value'],
            ['horas/turno', Disponibilidad]
        ]);

        var DisponibilidadOptions = {
            width:      tamaño,
            height:     tamaño,
            redFrom:    0,
            redTo:      3,
            yellowFrom: 3,
            yellowTo:   5.5,
            greenFrom:  5.5,
            greenTo:    8,
            minorTicks: 6,
            max:        8,
            majorTicks: ['0', '2', '4', '6', '8']
        };

        var DisponibilidadChart = new google.visualization.Gauge(document.getElementById('Disponibilidad_chart_turno'));
        DisponibilidadChart.draw(DisponibilidadData, DisponibilidadOptions); }
    </script>
    <td colspan="2"><div id="Disponibilidad_chart_turno"></div></td>
    