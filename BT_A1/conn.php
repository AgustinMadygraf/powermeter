<?php
$servername = "localhost";
$username = "root";
$password = "12345678";
$dbname = "powermeter";

// Función para conectar a la base de datos
function conectarBD()  {
    global $servername, $username, $password, $dbname;
    $conexion = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conexion) {
        die('Ha sucedido un error inesperado en la conexión de la base de datos<br>');}
    return $conexion; 
}

// Función para desconectar de la base de datos
function desconectarBD($conexion) {
    $close = mysqli_close($conexion);
    if (!$close) {
        die('Ha sucedido un error inesperado en la desconexion de la base de datos<br>'); }
    return $close;
}

// Función para obtener un array con el resultado de la consulta SQL
function getArraySQL($sql) {
    $conexion = conectarBD();
    if (!$result = mysqli_query($conexion, $sql)) {
        die(); }
    $rawdata = array();
    $i = 0;
    while ($row = mysqli_fetch_array($result)) {
        $rawdata[$i] = $row;
        $i++; }
    desconectarBD($conexion);
    return $rawdata;
}

// Obtener datos de la base de datos
date_default_timezone_set('America/Argentina/Buenos_Aires');
$sql = "SELECT `unixtime`, `potencia_III` FROM `inst_bt_a1` ORDER BY `inst_bt_a1`.`unixtime` DESC";
$rawdata = getArraySQL($sql);
$ult_time = $rawdata[0]["unixtime"];
$fechaHoraActual = date("Y-m-d H:i:s");
$unixtimeActual = strtotime($fechaHoraActual);
$dif_upd_sql = $unixtimeActual - $ult_time;
$upd_sql = false;

// Configuración de la URL del archivo CSV y la ubicación donde guardarlo
$url = 'http://panel.powermeter.com.ar/descargar/directa/inst/56ae1c10-059b-4764-abec-f7bdc5e56603/';
$save_location = 'C:/AppServ/www/mediciones/BT_A1/datos_inst.csv';

// Zona horaria
date_default_timezone_set('America/Argentina/Buenos_Aires');

// Obtenemos la fecha y hora actual
$fechaHoraActual = date("Y-m-d H:i:s");
$unixtimeActual = strtotime($fechaHoraActual);

// Cálculo de diferencias de tiempo
$archivo = 'datos_inst.csv';
$msg1 = 0;
if (file_exists($archivo)) {
    $fechaModificacion = filemtime($archivo);
    $msg1 = "<td>Fecha de modificación de <br> $archivo</td><td>$fechaModificacion</td><td> " . date('d-m-Y H:i:s', $fechaModificacion) . "</td>";
} else {
    $msg1 = "<td>El archivo $archivo no existe.</td>";
}
$msg2 = "";
$upd_sql = false;
$dif_upd_csv = $unixtimeActual - $fechaModificacion;
$dif2_upd_csv = 900 - $dif_upd_csv;

// Obtener horas, minutos y segundos a partir de $dif_upd_csv
$horas_csv = floor($dif_upd_csv / 3600);
$minutos_csv = floor(($dif_upd_csv % 3600) / 60);
$segundos_csv = $dif_upd_csv % 60;

// Formatear la cadena para que esté en formato hh:mm:ss
$dif_csv = sprintf("%02d:%02d:%02d", $horas_csv, $minutos_csv, $segundos_csv);

// Obtener horas, minutos y segundos a partir de $dif_upd_csv
$horas_sql = floor($dif_upd_sql / 3600);
$minutos_sql = floor(($dif_upd_sql % 3600) / 60);
$segundos_sql = $dif_upd_sql % 60;

// Formatear la cadena para que esté en formato hh:mm:ss
$dif_sql = sprintf("%02d:%02d:%02d", $horas_sql, $minutos_sql, $segundos_sql);

// Calcular la diferencia en días, horas, minutos y segundos
$dias_sql = floor($dif_upd_sql / (60 * 60 * 24));
$horas_sql = floor(($dif_upd_sql - ($dias_sql * 60 * 60 * 24)) / (60 * 60));
$minutos_sql = floor(($dif_upd_sql - ($dias_sql * 60 * 60 * 24) - ($horas_sql * 60 * 60)) / 60);
$segundos_sql = $dif_upd_sql - ($dias_sql * 60 * 60 * 24) - ($horas_sql * 60 * 60) - ($minutos_sql * 60);

if ($dif_upd_sql > 900) {
    $upd_sql = true;
}

// Ruta del archivo CSV
$csvFile = 'C:/AppServ/www/mediciones/BT_A1/datos_inst.csv';

// Función para obtener el número más grande del campo "timestamp"
function getLargestTimestamp($csvFile)
{
    $largestTimestamp = 0;
    if (($handle = fopen($csvFile, "r")) !== FALSE) {
        // Saltar la primera línea (cabecera)
        fgetcsv($handle);
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $timestamp = intval($data[1]);
            if ($timestamp > $largestTimestamp) {
                $largestTimestamp = $timestamp;
            }
        }
        fclose($handle);
    }
    return $largestTimestamp;
}

// Obtener el número más grande del campo "timestamp"
$ult_time_csv = getLargestTimestamp($csvFile);
$dif3_upd_csv = $unixtimeActual - $ult_time_csv;

$horas_csv3 = floor($dif3_upd_csv / 3600);
$minutos_csv3 = floor(($dif3_upd_csv % 3600) / 60);
$segundos_csv3 = $dif3_upd_csv % 60;

// Formatear la cadena para que esté en formato hh:mm:ss
$dif_csv3 = sprintf("%02d:%02d:%02d", $horas_csv3, $minutos_csv3, $segundos_csv3);

$ult_time_csv = getLargestTimestamp($csvFile);
$dif4_upd_csv = $ult_time_csv - $ult_time;

$horas_csv4 = floor($dif4_upd_csv / 3600);
$minutos_csv4 = floor(($dif4_upd_csv % 3600) / 60);
$segundos_csv4 = $dif4_upd_csv % 60;

// Formatear la cadena para que esté en formato hh:mm:ss
$dif_csv4 = sprintf("%02d:%02d:%02d", $horas_csv4, $minutos_csv4, $segundos_csv4);

// Cálculo viejo
$dias_csv = floor($dif_upd_csv / (60 * 60 * 24));
$horas_csv = floor(($dif_upd_csv - ($dias_csv * 60 * 60 * 24)) / (60 * 60));
$minutos_csv = floor(($dif_upd_csv - ($dias_csv * 60 * 60 * 24) - ($horas_csv * 60 * 60)) / 60);
$segundos_csv = $dif_upd_csv - ($dias_csv * 60 * 60 * 24) - ($horas_csv * 60 * 60) - ($minutos_csv * 60);

// Crear la conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Consulta para contar los registros totales
$sql_total = "SELECT COUNT(*) AS total_registros FROM inst_bt_a1";
$result_total = $conn->query($sql_total);
$row_total = $result_total->fetch_assoc();
$total_registros = $row_total['total_registros'];
$horas_totales = number_format($total_registros * 5 / 60, 1);

// Consulta para contar los registros mayores a 560W
$sql_mayores_560W = "SELECT COUNT(*) AS registros_mayores_560W FROM inst_bt_a1 WHERE potencia_III > 560";
$result_mayores_560W = $conn->query($sql_mayores_560W);
$row_mayores_560W = $result_mayores_560W->fetch_assoc();
$registros_mayores_560W = $row_mayores_560W['registros_mayores_560W'];
$horas_prod = number_format($registros_mayores_560W * 5 / 60, 1);

// Consulta para contar los registros menores a 560W
$sql_menores_560W = "SELECT COUNT(*) AS registros_menores_560W FROM inst_bt_a1 WHERE potencia_III <= 560";
$result_menores_560W = $conn->query($sql_menores_560W);
$row_menores_560W = $result_menores_560W->fetch_assoc();
$registros_menores_560W = $row_menores_560W['registros_menores_560W'];
$horas_improd = number_format($registros_menores_560W * 5 / 60, 1);
$disp = number_format(100 * $registros_mayores_560W / $total_registros, 3);

// Cerrar la conexión
$conn->close();
?>
