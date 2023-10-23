<!-- index.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="CSS/index.css">
    <link rel="stylesheet" type="text/css" href="CSS/header.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/imagenes/favicon.ico" type="image/x-icon">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/series-label.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script src="https://www.gstatic.com/charts/loader.js"></script>
    <style>
        /* Estilos para la tabla */
        table {
        border-collapse: collapse; /* Combina los bordes de las celdas */
        width: 100%;
        }

        /* Estilo para todas las celdas */
        table, th, td {
        border: 2px solid black; /* Define el grosor y el color del borde */
        }

        /* Estilo para las celdas de encabezado (th) */
        th {
        background-color: #f2f2f2; /* Color de fondo para las celdas de encabezado */
        }
    </style>

    
</head>
<body>
    <div class='topnav'>
        <ul>
            <li><a href="index.php" >Inicio</a></li>
            <li><a href="/phpMyAdmin/" target="_blank">Visit the AppServ Open Project</a></li>
            <li><a href="/powermeter/MyApp/Digirail/" target="_blank">Novus DigiRail</a></li>
            <li><a href="/powermeter/MyApp/Digirail/tabla.php" target="_blank">Novus DigiRail</a></li>

        </ul>
    </div>
    <br>
    <br>
    <?php require "dashboard.php"; ?>
    <?php require "power_info_display.php"; ?>
    <?php require "chart_viewer.php"; ?>
    <p> El objetivo es democratizar la información para que la toma de decisiones sea inteligente. <br>La información es generada mediante el procesamiento automático de datos confiables y objetivos.<br></p>
    <table style="border-collapse: collapse; width: 100%;">
        <tr>
            <th>Descipción</th>
            <th colspan="2">Mes</th>
            <th colspan="2">Semana</th>
            <th colspan="2">Turno</th>   
        </tr>

        <tr>
            <td>Gráfico</td>
            <?php require "chart_viewer_mes.php"; ?>
            <?php require "chart_viewer_semana.php"; ?>
            <?php require "chart_viewer_turno.php"; ?>
        </tr>
        <tr>
            <td colspan="7"> . </td>
        </tr>
        <tr>
            <td rowspan="2">Tiempo</td>
            <td> inicio</td>
            <td> Fin</td>
            <td> inicio</td>
            <td> Fin</td>
            <td> inicio</td>
            <td> Fin</td>
        </tr>
        <tr>
            <td> <?php echo date('Y-m-d H:i:s',$tiempo1_mes);?></td>
            <td> <?php echo date('Y-m-d H:i:s',$tiempo2);?></td>
            <td> <?php echo date('Y-m-d H:i:s',$tiempo1_semana);?></td>
            <td> <?php echo date('Y-m-d H:i:s',$tiempo2);?></td>
            <td> <?php echo date('Y-m-d H:i:s',$tiempo1_turno);?></td>
            <td> <?php echo date('Y-m-d H:i:s',$tiempo2);?></td>
        </tr>

        <tr>
            <td colspan="7"> . </td>
        </tr>
        <tr>
            <td>Horas calendario</td>
            <td colspan="2"> <?php echo $horas_mes.     " horas y ".$minutos_mes.   " minutos";?> </td>
            <td colspan="2"> <?php echo $horas_semana.  " horas y ".$minutos_semana." minutos";?> </td>
            <td colspan="2"> <?php echo $horas_turno.   " horas y ".$minutos_turno. " minutos";?> </td>
        </tr>
        <tr>
            <td>Tiempo máquina en producción</td>
            <td colspan="2"> <?php echo $horas_operativas_mes." horas y ".$minutos_operativas_mes." minutos";?> </td>
            <td colspan="2"> <?php echo $horas_operativas_semana." horas y ".$minutos_operativas_semana." minutos";?> </td>
            <td colspan="2"> <?php echo $horas_operativas_turno." horas y ".$minutos_operativas_turno." minutos";?> </td>

        </tr>
        <tr>
            <td>Tiempo maquina parada</td>    
            <td colspan="2"> <?php echo $horas_parada_mes.      " horas y ".$minutos_parada_mes.    " minutos";?> </td>
            <td colspan="2"> <?php echo $horas_parada_semana.   " horas y ".$minutos_parada_semana. " minutos";?> </td>
            <td colspan="2"> <?php echo $horas_parada_turno.    " horas y ".$minutos_parada_turno.  " minutos";?> </td>
        </tr>
        <tr>
            <td>Disponiblidad operativa[%]</td>    
            <td colspan="2"> <?php echo $disp_mes;?> </td>
            <td colspan="2"> <?php echo $disp_semana;?> </td>
            <td colspan="2"> <?php echo $disp_turno;?> </td>

        </tr>
    </table>
    <title><?php echo "Pot: " . round($potinst, 1); ?> kW</title>
</body>
</html>
