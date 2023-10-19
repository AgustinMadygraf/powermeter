<!-- dashboard.php -->
<?php
date_default_timezone_set('America/Argentina/Buenos_Aires');
setlocale(LC_TIME, "spanish");
$segundos = 60;   // Refrescar cada 60 segundos


// Variable que registra qué período de tiempo mostrar por defecto
$periodo = 'turno';
$ls_periodos = ['semana' => 604800, 'turno' => 28800, 'hora' => 3600];
$ls_class = ['semana' => [1, 0, 0], 'turno' => [0, 1, 0], 'hora' => [0, 0, 1]];
$ref_class = ['presione', 'presado'];
$menos_periodo = ['semana' => 'turno', 'turno' => 'hora', 'hora' => 'hora'];

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
$tiempo1 = $conta/1000; 
$tiempo1 = $tiempo1- $ls_periodos[$periodo] - 80*60;
$tiempo2 = $conta/1000 ;
//$tiempo2 = $tiempo2 + 4*5*60; 
$sql = "SELECT `unixtime`, `potencia_III`  from `inst_bt_a1` WHERE  unixtime > " . $tiempo1 . " and unixtime <= " . $tiempo2 . " ORDER BY `unixtime` ASC ;";
$rawdata = getArraySQL($sql);
echo "tiempo1: ".$tiempo1."<br>";
echo "tiempo2: ".$tiempo2."<br>";
echo "ls_periodos[$periodo]: ".$ls_periodos[$periodo]."<br>";



$costo = round($pot * 1.36 * 14.648, 2);
$costo2 = round($pot * 1.36 * 4.702, 2);
$CO2 = round($pot * 0.36, 2);

$sql = "SELECT COUNT(*) AS total_registros FROM inst_bt_a1";
$sql_total = getArraySQL($sql);
$total_registros = $sql_total[0]['total_registros'];
$horas_totales = number_format($total_registros * 5 / 60, 1);


$sql = "SELECT COUNT(*) AS registros_mayores_440W FROM inst_bt_a1 WHERE potencia_III > 440";
$sql_total = getArraySQL($sql);
$registros_mayores_440W = $sql_total[0]['registros_mayores_440W'];
$horas_prod = number_format($registros_mayores_440W * 5 / 60, 1);

$sql = "SELECT COUNT(*) AS registros_menores_440W FROM inst_bt_a1 WHERE potencia_III <= 440";
$sql_total = getArraySQL($sql);
$registros_menores_440W = $sql_total[0]['registros_menores_440W'];
$horas_improd = number_format($registros_menores_440W * 5 / 60, 1);
$disp = number_format(100 * $registros_mayores_440W / $total_registros, 3);

?>
