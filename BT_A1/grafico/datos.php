<?php
// En este archivo se debe realizar la consulta a la base de datos y devolver los datos en formato JSON
include 'conn2.php';

$conta = isset($_GET['conta']) ? intval($_GET['conta']) : 0;

$sql = "SELECT * FROM inst_bt_a1 WHERE unixtime > " . ($conta - $periodo) . " AND unixtime <= " . $conta . " ORDER BY unixtime ASC";
$rawdata = ejecutarConsulta($sql);

$data = array();
foreach ($rawdata as $row) {
    $unixtime_v2 = $row["unixtime"] * 1000;
    $pot_III = $row["potencia_III"];
    if ($pot_III === null) {
        $pot_III = 0;
    }
    $data[] = array($unixtime_v2, $pot_III);
}

// Devolver los datos en formato JSON
header('Content-Type: application/json');
echo json_encode($data);
?>
