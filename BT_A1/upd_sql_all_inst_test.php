<?php
// URL del archivo procesar_powermeter.php
$url = 'http://localhost/mediciones/BT_A1/procesar_powermeter.php';

// Función para mostrar mensajes de error
function show_error($error_message) {
    echo "Error: " . $error_message . PHP_EOL;
}

// Función para validar los datos
function validate_data($data) {
    // Aquí puedes agregar las validaciones necesarias según tus requisitos
    // Por ejemplo, verificar que las columnas requeridas existan y que los datos sean numéricos
    return true;
}

// Obtener el contenido del archivo datos_inst.csv
$file_content = file_get_contents('datos_inst.csv');
if ($file_content === false) {
    show_error("Error al leer el archivo datos_inst.csv.");
    exit();
}

// Convertir el contenido del archivo CSV a un array de filas
$rows = explode("\n", $file_content);

// Omitir la primera fila (encabezados)
array_shift($rows);

// Iterar sobre cada fila del archivo CSV
foreach ($rows as $row) {
    // Si la fila está vacía, continuar con la siguiente
    if (empty($row)) {
        continue;
    }

    // Convertir la fila en un array asociativo usando los nombres de columna como claves
    $columns = explode(",", $row);
    $data = array(
        'timestamp' => $columns[1],
        'R:p' => $columns[4],
        'S:p' => $columns[8],
        'T:p' => $columns[12],
        'R:v' => $columns[2],
        'S:v' => $columns[6],
        'T:v' => $columns[10]
    );

    // Validar los datos de la fila actual
    if (!validate_data($data)) {
        show_error("Datos inválidos en la fila: " . $row);
        continue;
    }

    // Enviar los datos a procesar_powermeter.php usando el método GET
    $params = http_build_query($data);
    $response = file_get_contents($url . '?' . $params);

    // Mostrar la respuesta del servidor
    if ($response !== false) {
        echo $response . PHP_EOL;
        // Verificar si el mensaje es "El registro ya existe en la base de datos"
        if (strpos($response, "El registro ya existe en la base de datos") !== false) {
            echo "El registro ya existe en la base de datos." . PHP_EOL;
        }
    } else {
        show_error("Error al enviar datos: No se pudo acceder a la URL.");
    }
}

echo "Proceso finalizado.";
?>
