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
$fechaHoraActual = date("Y-m-d H:i:s");                                         //[A]
$unixtimeActual = strtotime($fechaHoraActual);                                  //[A] Fecha y hora actual
$ult_time = $rawdata[0]["unixtime"];                                            //[B] última actualización SQL
$dif_upd_sql = $unixtimeActual - $ult_time;                                     //[A-B]
$url = 'http://panel.powermeter.com.ar/descargar/directa/inst/56ae1c10-059b-4764-abec-f7bdc5e56603/';
$location_datos_inst_csv = 'C:/AppServ/www/CSV/powermeter/datos_inst.csv';
date_default_timezone_set('America/Argentina/Buenos_Aires');




// Cálculo de diferencias de tiempo
if (file_exists($location_datos_inst_csv)) {
    $fechaModificacion = filemtime($location_datos_inst_csv);                   //[C] Fecha modificacionCSV
    $msg1 = "<td>Fecha de modificación de <br> $location_datos_inst_csv</td><td>$fechaModificacion</td><td> " . date('d-m-Y H:i:s', $fechaModificacion) . "</td>";
} else {
    $msg1 = "<td>El archivo $location_datos_inst_csv no existe.</td>";
}

$dif_upd_csv = $unixtimeActual - $fechaModificacion;                            // [A-C]tiempo desde última vez descargado CSV
$horas_csv = floor($dif_upd_csv / 3600);                                        // [A-C]tiempo desde última vez descargado CSV
$minutos_csv = floor(($dif_upd_csv % 3600) / 60);                               // [A-C]tiempo desde última vez descargado CSV
$segundos_csv = $dif_upd_csv % 60;                                              // [A-C]tiempo desde última vez descargado CSV
$dif_csv = sprintf("%02d:%02d:%02d", $horas_csv, $minutos_csv, $segundos_csv);  // [A-C]tiempo desde última vez descargado CSV



$horas_sql = floor($dif_upd_sql / 3600);                                        //[A-B] Diferencia SQL	
$minutos_sql = floor(($dif_upd_sql % 3600) / 60);                               //[A-B] Diferencia SQL	
$segundos_sql = $dif_upd_sql % 60;                                              //[A-B] Diferencia SQL	
$dif_sql = sprintf("%02d:%02d:%02d", $horas_sql, $minutos_sql, $segundos_sql);  //[A-B] Diferencia SQL	


function getLargestTimestamp($location_datos_inst_csv){                                         // Función para obtener el número más grande del campo "timestamp"
    if (!file_exists($location_datos_inst_csv)) { return 0; }
    $timestamps = array_map('intval', array_column(array_map('str_getcsv', file($location_datos_inst_csv)), 1));
    return max($timestamps);}
$ult_time_csv = getLargestTimestamp($location_datos_inst_csv);

$dif3_upd_csv = $unixtimeActual - $ult_time_csv;

$horas_csv3 = floor($dif3_upd_csv / 3600);
$minutos_csv3 = floor(($dif3_upd_csv % 3600) / 60);
$segundos_csv3 = $dif3_upd_csv % 60;

// Formatear la cadena para que esté en formato hh:mm:ss
$dif_csv3 = sprintf("%02d:%02d:%02d", $horas_csv3, $minutos_csv3, $segundos_csv3);

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

// Consulta para contar los registros mayores a 440W
$sql_mayores_440W = "SELECT COUNT(*) AS registros_mayores_440W FROM inst_bt_a1 WHERE potencia_III > 440";
$result_mayores_440W = $conn->query($sql_mayores_440W);
$row_mayores_440W = $result_mayores_440W->fetch_assoc();
$registros_mayores_440W = $row_mayores_440W['registros_mayores_440W'];
$horas_prod = number_format($registros_mayores_440W * 5 / 60, 1);

// Consulta para contar los registros menores a 440W
$sql_menores_440W = "SELECT COUNT(*) AS registros_menores_440W FROM inst_bt_a1 WHERE potencia_III <= 440";
$result_menores_440W = $conn->query($sql_menores_440W);
$row_menores_440W = $result_menores_440W->fetch_assoc();
$registros_menores_440W = $row_menores_440W['registros_menores_440W'];
$horas_improd = number_format($registros_menores_440W * 5 / 60, 1);
$disp = number_format(100 * $registros_mayores_440W / $total_registros, 3);

// Cerrar la conexión
$conn->close();
?>
