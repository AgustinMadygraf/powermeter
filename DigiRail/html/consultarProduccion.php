<?php
// consultarProduccion.php
// Parámetros de conexión
$servername = "localhost";
$username = "root";
$password = "12345678";
$dbname = "novus";

// Establecer la zona horaria de Buenos Aires
date_default_timezone_set('America/Buenos_Aires');

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Recibir parámetros de inicio y fin en formato Unix time
$inicioUnix = $_GET['inicio'];
$finUnix = $_GET['fin'];

// Convertir tiempo Unix a formato datetime de MySQL
$inicio = date('Y-m-d H:i:s', $inicioUnix);
$fin = date('Y-m-d H:i:s', $finUnix);

// Consulta SQL para obtener los valores de HR_COUNTER1 en las fechas inicio y fin
$sqlInicio = "SELECT HR_COUNTER1 FROM maq_bolsas WHERE unixtime >= '$inicioUnix' ORDER BY unixtime ASC LIMIT 1";
$sqlFin = "SELECT HR_COUNTER1 FROM maq_bolsas WHERE unixtime <= '$finUnix' ORDER BY unixtime DESC LIMIT 1";

$resultInicio = $conn->query($sqlInicio);
$resultFin = $conn->query($sqlFin);

    // Obtener los valores de HR_COUNTER1
    $rowInicio = $resultInicio->fetch_assoc();
    $rowFin = $resultFin->fetch_assoc();

    $hr_counterInicio = $rowInicio["HR_COUNTER1"];
    $hr_counterFin = $rowFin["HR_COUNTER1"];

    // Calcular la diferencia
    $diferencia = $hr_counterFin - $hr_counterInicio;

    // Preparar el resultado
    echo "diferencia = ".$diferencia."<br>";
    echo "hr_counterInicio = ".$hr_counterInicio."<br>";
    echo "hr_counterFin = ".$hr_counterFin."<br>";


// Cerrar conexión
$conn->close();
?>
