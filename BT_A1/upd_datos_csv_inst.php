<?php
$archivo = 'datos_inst.csv';
$save_location = 'C:/AppServ/www/powermeter/BT_A1/datos_inst.csv';
$url = 'http://panel.powermeter.com.ar/descargar/directa/inst/56ae1c10-059b-4764-abec-f7bdc5e56603/';
$destino = "index.php";
// Realizar la descarga y guardar el archivo en la ubicación especificada  
$response = file_get_contents($url);
if ($response !== false) {
    if (file_put_contents($save_location, $response) !== false) {
        $msg2 = "Archivo CSV descargado y guardado correctamente";
    } else {
        $msg2 = "Error al guardar el archivo";
    }
} else {
    $msg2 = "Error al descargar el archivo";
}
?>

<script>
    // Mostrar una alerta
    alert("<?php echo $msg2; ?>");
    
    // Redireccionar a index.php después de aceptar la alerta
    window.location.href = 'index.php';
</script>
