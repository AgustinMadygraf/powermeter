<?php
#mostrar_horas.php
include 'templates/header.php'; 
require_once 'includes/db.php';
require_once 'legajo.php';






// Preparar la consulta SQL
$sql = "SELECT * FROM registro_horas_trabajo WHERE legajo = ? AND horas_trabajadas > 1 ORDER BY fecha ASC";

// Preparar la sentencia
$stmt = $conexion->prepare($sql);

// Vincular parámetros
$stmt->bind_param("s", $legajo);

// Ejecutar la sentencia
$stmt->execute();

// Obtener los resultados
$resultado = $stmt->get_result();

// Cerrar la sentencia
$stmt->close();

// Comenzar el HTML
echo "<!DOCTYPE html><html><head><title>Registro de Horas</title></head><body>";
function obtenerNombreCentroCosto($codigo) {
    $nombresCentroCosto = [
        '1' => 'Maquina de bolsas',
        '2' => 'Boletas y folletería',
        '3' => 'Logistica',
        '4' => 'Administración',
        // Agrega más códigos y nombres según sea necesario
    ];

    return isset($nombresCentroCosto[$codigo]) ? $nombresCentroCosto[$codigo] : 'Desconocido';
}


// Verificar si hay resultados y mostrarlos
if ($resultado->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>Legajo</th>
                <th>Fecha</th>
                <th>Horas</th>
                <th>Centro de costo</th>
                <th>Proceso</th>
            </tr>";
    while($fila = $resultado->fetch_assoc()) {
        echo "<tr>
                <td>".$fila["legajo"]."</td>
                <td>".$fila["fecha"]."</td>  
                <td>".$fila["horas_trabajadas"]."</td><td>";
                echo obtenerNombreCentroCosto($fila["centro_costo"]);
                echo "</td><td>".$fila["proceso"]."</td> </tr>";
    }
    echo "</table>";
} else {
    echo "No se encontraron resultados.";
}


// Finalizar el HTML
echo "</body></html>";

// Cerrar la conexión
$conexion->close();
?>
