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

    
</head>
<body>
    <div class='topnav'>
        <ul>
            <li><a href='setup1.php' target="_blank">Ir a Setup</a></li>
            <li><a href='/index2.php' target="_blank">Ir a App</a></li>
            <li><a href="/phpMyAdmin/" target="_blank">Visit the AppServ Open Project</a></li>
            <li><a href="/register/cargaArchivo.php" target="_blank">Register Cargar archivo</a></li>
            <li><a href="/register/carga_CSV/" target="_blank">Register Subir archivo</a></li>
            <li><a href="/stock/index.php?Formato=todos&color=todos&gramaje=todos" target="_blank">Bolsas de Papel</a></li>
            <li><a href="/powermeter" target="_blank">Powermeter</a></li>
        </ul>
    </div>
    <br>
    <br>
    <?php require "dashboard.php"; ?>
    <?php require "power_info_display.php"; ?>
    <?php require "chart_viewer.php"; ?>
    <?php require "chart_viewer_2.php"; ?>
    <title><?php echo "Pot: " . round($potinst, 1); ?> kW</title>
</body>
</html>
