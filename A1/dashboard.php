<!-- dashboard.php -->
<?php
date_default_timezone_set('America/Argentina/Buenos_Aires');
setlocale(LC_TIME, "spanish");
$segundos = 60;   // Refrescar cada 60 segundos


// Variable que registra qué período de tiempo mostrar por defecto
$periodo = 'semana';
$ls_periodos = ['mes' => 2419200, 'semana' => 604800, 'turno' => 28800];
$ls_class = ['mes' => [1, 0, 0], 'semana' => [0, 1, 0], 'turno' => [0, 0, 1]];
$ref_class = ['presione', 'presado'];
$menos_periodo = ['mes' => 'semana', 'semana' => 'turno', 'turno' => 'turno'];

// Comprobar si se cambió el período a través de GET
if ($_GET && array_key_exists("periodo", $_GET)) {
    if (array_key_exists($_GET["periodo"], $ls_periodos)) {
        $periodo = $_GET["periodo"];
    }
}
$class = $ls_class[$periodo];

// Conectar a la base de datos
function conectarBD() {
    require 'includes/conn.php';
    $BD = "powermeter";
    $conexion = mysqli_connect($server, $usuario, $pass, $BD);
    if (!$conexion) {
        echo 'Ha sucedido un error inesperado en la conexión de la base de datos<br>';
    }
    return $conexion;
}

// Desconectar la conexión a la base de datos
function desconectarBD($conexion) {
    $close = mysqli_close($conexion);
    if (!$close) {
        echo 'Ha sucedido un error inesperado en la desconexión de la base de datos<br>';
    }
    return $close;
}

// Obtener un array multidimensional con el resultado de la consulta
function getArraySQL($sql) {
    $conexion = conectarBD();
    if (!$result = mysqli_query($conexion, $sql)) die();

    $rawdata = array();
    $i = 0;
    while ($row = mysqli_fetch_array($result)) {
        $rawdata[$i] = $row;
        $i++;
    }

    desconectarBD($conexion);
    return $rawdata;
}

function sql_query($campo) {
    return "SELECT `unixtime`, `$campo` FROM `inst_bt_a1`  ORDER BY `unixtime` DESC LIMIT 1";
}

$res = getArraySQL(sql_query("potencia_III"));
$potinst = $res[0]['potencia_III'];
$unixtime = $res[0]['unixtime'] ;



if ($pot > 292) {
    if ($potinst > 299) {
        $segundos = 54;
        echo " <audio src='archivos/alert-1.mp3' autoplay> </audio>";
    }
}

// Si la variable 'test' aparece en $_GET, el refresco se hace cada segundo en vez de cada 20 segundos.
header("Refresh:" . $segundos);

// Valores para la ubicación del degradado de advertencia
$d = array();
for ($i = 0; $i < 4; $i++) {
    $d[$i] = 350 - $pot - 10 * $i;
}

$date = date(DATE_RFC2822);
$newDate = date("D, d M Y" . (" 00:00:00") . " O");

$valorInicial = $unixtime * 1000;
$conta = $valorInicial;
if ($_GET && array_key_exists("conta", $_GET)) {
    $conta = $_GET["conta"];
    if ($conta > $valorInicial) {
        $conta = $valorInicial;
    }
}

$tiempo1 = ($conta/1000) - $ls_periodos[$periodo] - 80*60;
$tiempo2 = $conta/1000 ;
$sql = "SELECT `unixtime`, `potencia_III`  from `inst_bt_a1` WHERE  unixtime > " . $tiempo1 . " AND unixtime <= " . $tiempo2 . " ORDER BY `unixtime` ASC ;";
$rawdata = getArraySQL($sql);

$tiempo1_mes    = ($conta/1000) - $ls_periodos['mes']   ;
$tiempo1_semana = ($conta/1000) - $ls_periodos['semana'];
$tiempo1_turno  = ($conta/1000) - $ls_periodos['turno'] ;





$sql = "SELECT COUNT(*) AS registros_mayores_440W_mes FROM inst_bt_a1 WHERE unixtime > " . $tiempo1_mes . " AND unixtime <= " . $tiempo2 . " AND potencia_III > 440";
//$sql = "SELECT COUNT(*) AS registros_mayores_440W FROM inst_bt_a1 WHERE potencia_III > 440";
$sql_total = getArraySQL($sql);
$registros_mayores_440W_mes = $sql_total[0]['registros_mayores_440W_mes'];
$horas_operativas_mes = floor($registros_mayores_440W_mes * 5 / 60); // Obtener las horas completas
$minutos_operativas_mes = ($registros_mayores_440W_mes * 5) % 60; // Obtener los minutos restantes

$sql = "SELECT COUNT(*) AS registros_menores_440W_mes FROM inst_bt_a1 WHERE unixtime > " . $tiempo1_mes . " AND unixtime <= " . $tiempo2 . " AND potencia_III <= 440";
$sql_total = getArraySQL($sql);
$registros_menores_440W_mes = $sql_total[0]['registros_menores_440W_mes'];
$horas_parada_mes = floor($registros_menores_440W_mes * 5 / 60); // Obtener las horas completas
$minutos_parada_mes = ($registros_menores_440W_mes * 5) % 60; // Obtener los minutos restantes

$horas_mes = floor(($registros_menores_440W_mes + $registros_mayores_440W_mes) *5 / 60);
$minutos_mes = ($registros_menores_440W_mes + $registros_mayores_440W_mes * 5) % 60;
$disp_mes = number_format(100 * $registros_mayores_440W_mes / ($registros_mayores_440W_mes + $registros_menores_440W_mes), 1);






$sql = "SELECT COUNT(*) AS registros_mayores_440W_semana FROM inst_bt_a1 WHERE unixtime > " . $tiempo1_semana . " AND unixtime <= " . $tiempo2 . " AND potencia_III > 440";
//$sql = "SELECT COUNT(*) AS registros_mayores_440W FROM inst_bt_a1 WHERE potencia_III > 440";
$sql_total = getArraySQL($sql);
$registros_mayores_440W_semana = $sql_total[0]['registros_mayores_440W_semana'];
$horas_operativas_semana = floor($registros_mayores_440W_mes * 5 / 60); // Obtener las horas completas
$minutos_operativas_semana = ($registros_mayores_440W_mes * 5) % 60; // Obtener los minutos restantes

$sql = "SELECT COUNT(*) AS registros_menores_440W_semana FROM inst_bt_a1 WHERE unixtime > " . $tiempo1_semana . " AND unixtime <= " . $tiempo2 . " AND potencia_III <= 440";
$sql_total = getArraySQL($sql);
$registros_menores_440W_semana = $sql_total[0]['registros_menores_440W_semana'];
$horas_parada_semana = floor($registros_menores_440W_semana * 5 / 60); // Obtener las horas completas
$minutos_parada_semana = ($registros_menores_440W_semana * 5) % 60; // Obtener los minutos restantes

$horas_semana = floor(($registros_menores_440W_semana + $registros_mayores_440W_semana ) *5 / 60);
$minutos_semana = ($registros_menores_440W_semana + $registros_mayores_440W_semana * 5) % 60;
$disp_semana = number_format(100 * $registros_mayores_440W_semana / ($registros_mayores_440W_semana + $registros_menores_440W_semana), 1);






$sql = "SELECT COUNT(*) AS registros_mayores_440W_turno FROM inst_bt_a1 WHERE unixtime > " . $tiempo1_turno . " AND unixtime <= " . $tiempo2 . " AND potencia_III > 440";
//$sql = "SELECT COUNT(*) AS registros_mayores_440W FROM inst_bt_a1 WHERE potencia_III > 440";
$sql_total = getArraySQL($sql);
$registros_mayores_440W_turno = $sql_total[0]['registros_mayores_440W_turno'];
$horas_operativas_turno = floor($registros_mayores_440W_turno * 5 / 60); // Obtener las horas completas
$minutos_operativas_turno = ($registros_mayores_440W_turno * 5) % 60; // Obtener los minutos restantes

$sql = "SELECT COUNT(*) AS registros_menores_440W_turno FROM inst_bt_a1 WHERE unixtime > " . $tiempo1_turno . " AND unixtime <= " . $tiempo2 . " AND potencia_III <= 440";
$sql_total = getArraySQL($sql);
$registros_menores_440W_turno = $sql_total[0]['registros_menores_440W_turno'];
$horas_parada_turno = floor($registros_menores_440W_turno * 5 / 60);
$minutos_parada_turno = ($registros_menores_440W_turno * 5) % 60; // Obtener los minutos restantes

$horas_turno = floor(($registros_menores_440W_turno + $registros_mayores_440W_turno) *5 / 60);
$minutos_turno = ($registros_menores_440W_turno + $registros_mayores_440W_turno * 5) % 60;
$disp_turno = number_format(100 * $registros_mayores_440W_turno / ($registros_mayores_440W_turno + $registros_menores_440W_turno), 1);










?>
