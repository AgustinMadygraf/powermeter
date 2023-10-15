<!-- dashboard.php -->
<?php
date_default_timezone_set('America/Argentina/Buenos_Aires');
setlocale(LC_TIME, "spanish");
$segundos = 60;   // Refrescar cada 60 segundos


// Variable que registra qué período de tiempo mostrar por defecto
$periodo = 'dia';
$ls_periodos = ['semana' => 604800000, 'dia' => 88000000, 'hora' => 8500000];
$ls_class = ['semana' => [1, 0, 0], 'dia' => [0, 1, 0], 'hora' => [0, 0, 1]];
$ref_class = ['presione', 'presado'];
$menos_periodo = ['semana' => 'dia', 'dia' => 'hora', 'hora' => 'hora'];

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
    return "SELECT `unixtime`, `$campo` FROM `inst_bt_a1`  ORDER BY `unixtime` DESC LIMIT 16";
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
$tiempo1 = $conta - $ls_periodos[$periodo];
$tiempo1 = $tiempo1/1000;
$tiempo2 = $conta ;
$tiempo2 = $tiempo2/1000;
$sql = "SELECT `unixtime`, `potencia_III`  from `inst_bt_a1` WHERE  unixtime > " . $tiempo1 . " and unixtime <= " . $tiempo2 . " ORDER BY `unixtime` ASC ;";
$rawdata = getArraySQL($sql);



$costo = round($pot * 1.36 * 14.648, 2);
$costo2 = round($pot * 1.36 * 4.702, 2);
$CO2 = round($pot * 0.36, 2);
?>
