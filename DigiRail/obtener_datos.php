<!-- obtener_datos.php -->

<?php
// Datos de conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "12345678";
$database = "novus";

// Crear una conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Consulta SQL para seleccionar las filas 70, 71, 72 y 73
$sql = "SELECT * FROM registros_modbus WHERE ID IN (70, 71, 72, 73)";
$result = $conn->query($sql);

$data = array(); // Crear un arreglo para almacenar los datos

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row; // Agregar cada fila como un elemento al arreglo
    }
}

// Cerrar la conexión a la base de datos
$conn->close();

// Devolver los datos en formato JSON
header('Content-Type: application/json');
echo json_encode($data);
?>
