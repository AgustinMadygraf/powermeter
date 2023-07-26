<?php
// Configuración de conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "12345678";
$dbname = "powermeter";

// Conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión a la base de datos: " . $conn->connect_error);
}

// Función para validar y sanitizar los datos
function validateAndSanitize($data)
{
    // Aplicar validaciones y saneamiento aquí según tus requisitos
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    // Convertir $unixtime a múltiplo de 10
    $data = round($data / 10) * 10;
    // Agregar más validaciones según lo necesites
    return $data;
}

// Obtener valores del formulario
if ($_SERVER["REQUEST_METHOD"] === "GET") {
    if (isset($_GET['unixtime']) && isset($_GET['potencia_r']) && isset($_GET['potencia_s']) && isset($_GET['potencia_t']) && isset($_GET['v_r']) && isset($_GET['v_s']) && isset($_GET['v_t'])) {
        $unixtime = validateAndSanitize($_GET['unixtime']);
        $potencia_r = validateAndSanitize($_GET['potencia_r']);
        $potencia_s = validateAndSanitize($_GET['potencia_s']);
        $potencia_t = validateAndSanitize($_GET['potencia_t']);
        $v_r = validateAndSanitize($_GET['v_r']);
        $v_s = validateAndSanitize($_GET['v_s']);
        $v_t = validateAndSanitize($_GET['v_t']);

        // Verificar si ya existe un registro con el mismo valor de unixtime
        $sql = "SELECT * FROM inst_bt_a1 WHERE unixtime = '$unixtime'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            echo "El registro ya existe en la base de datos.";
        } else {
            // Insertar datos en la base de datos
            $sql = "INSERT INTO inst_bt_a1 (unixtime, potencia_r, potencia_s, potencia_t, v_r, v_s, v_t) VALUES ('$unixtime', '$potencia_r', '$potencia_s', '$potencia_t', '$v_r', '$v_s', '$v_t' )";

            if ($conn->query($sql) === TRUE) {
                echo "Los datos han sido ingresados correctamente en la base de datos";
            } else {
                echo "Error al ingresar datos: " . $conn->error;
            }
        }
    } else {
        echo "Faltan parámetros en la solicitud.";
    }
} else {
    echo "Solicitud inválida.";
}

// Cerrar conexión a la base de datos
$conn->close();
?>
