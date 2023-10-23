<script> //Configuración y creación del gráfico Disponibilidad 
        google.charts.load('current', {'packages':['gauge']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
        // Obtener la Disponibilidad de la máquina desde tu fuente de datos
        var Disponibilidad = <?php echo number_format($disp_semana*1.68,2);?>;
        var tamaño = 350;

        var DisponibilidadData = google.visualization.arrayToDataTable([
            ['Label', 'Value'],
            ['horas/semana', Disponibilidad]
        ]);

        var DisponibilidadOptions = {
            width:      tamaño,
            height:     tamaño,
            redFrom:    0,
            redTo:      64,
            yellowFrom: 64,
            yellowTo:   96,
            greenFrom:  96,
            greenTo:    168,
            minorTicks: 6,
            max:        168,
            majorTicks: ['0', '24', '72', '96', '120', '144', '168']
        };

        var DisponibilidadChart = new google.visualization.Gauge(document.getElementById('Disponibilidad_chart_semana'));
        DisponibilidadChart.draw(DisponibilidadData, DisponibilidadOptions); }
    </script>
    <td colspan="2"><div id="Disponibilidad_chart_semana"></div></td>
    