<!--index.php -->

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
    <?php require 'conn.php'; ?>    <!-- Gráficos -->     
   
    <script> //Configuración y creación del gráfico Disponibilidad 
        google.charts.load('current', {'packages':['gauge']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
        // Obtener la velocidad de la máquina desde tu fuente de datos
        var velocidad = <?php echo number_format($disp*1.68,2);?>;
        var tamaño = 350;

        var velocidadData = google.visualization.arrayToDataTable([
            ['Label', 'Value'],
            ['horas/semana', velocidad]
        ]);

        var velocidadOptions = {
            width: tamaño,
            height: tamaño,
            redFrom: 0,
            redTo: 64,
            yellowFrom: 64,
            yellowTo: 96,
            greenFrom: 96,
            greenTo: 168,
            minorTicks: 6,
            max: 168,
            majorTicks: ['0', '24', '72', '96', '120', '144', '168']
        };

        var velocidadChart = new google.visualization.Gauge(document.getElementById('velocidad_chart_div'));
        velocidadChart.draw(velocidadData, velocidadOptions); }
    </script>
    <header>
        <?php require 'header.php'; ?> 
    </header>
    <nav style="position: relative;">
        <?php require 'grafico.php'; ?>
    </nav>
    <br>
    <br>
    <br>
    <main class="flex-container">
        <section class="flex-item" >
            <p> El objetivo es democratizar la información para que la toma de decisiones sea inteligente. 
            <br>La información es generada mediante el procesamiento automático de datos confiables y objetivos.
            <br>
            </p>
            <table>
                <tr>
                    <td>Horas totales de Máquina <br>en producción: </td>    
                    <td><?php echo $horas_prod;?>       </td>
                </tr>
                <tr>
                    <td>Horas totales de Máquina <br>parada:        </td>          
                    <td><?php echo $horas_improd;?>     </td>
                <tr>
                </tr>
                    <td>Disponibilidad:                 </td>                   
                    <td><?php echo $disp;?>  %          </td>
                </tr>
                </tr>
                    <td>Horas por semana <br>totales               </td>                   
                    <td> 3 * 8 * 7 =  168 horas         </td>
                </tr>
                </tr>
                    <td>Cantidad de turnos <br>de 8 horas   </td>                   
                    <td> 2                              </td>
                </tr>
                </tr>
                    <td>Días laborales por semana                 </td>                   
                    <td> 4                              </td>
                </tr>
                </tr>
                    <td>Horas por semana de <br>producción estimada</td>                   
                    <td> 2 * 8 * 4 =  64 horas          </td>
                </tr>
                </tr>
                    <td>Horas por semana de <br>producción real</td>                   
                    <td> <?php echo number_format($disp*1.68,1);?> horas        </td>
                </tr>
                </tr>
                    <td>Horas de producción real<br>sobre <br> horas de producción estimada</td>                   
                    <td> <?php echo number_format( $disp*168/64,1);?> %        </td>
                </tr>
            </table>
        </section>
        <section class="flex-item" >
            <div id="velocidad_chart_div"></div>
        </section>
        <section class="flex-item" >
            <?php //if ($dif_upd_csv  > 900) { require 'upd_datos_csv_inst.php'; }?>
            <?php //if ($dif4_upd_csv > 120) { require 'upd_sql_all_inst2.php'; }?>
            <?php if (isset($_GET['table']) && $_GET['table'] === 'true') { require "table.php";}?>
        </section>
    </main>
    <br>
    <br>
    <br>
    <br>
    <footer>
        <?php require "footer.php";?>
    </footer>
</body>
</html>
