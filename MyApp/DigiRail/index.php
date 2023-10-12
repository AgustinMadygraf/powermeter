<!DOCTYPE html>
<html>
<head>
    <title>Tabla de Registros Modbus</title>
</head>
<body>
    <h2>Tabla de Registros Modbus</h2>
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

    // Consulta SQL para seleccionar todos los registros
    $sql = "SELECT * FROM registros_modbus";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table border='1'>
        <tr>
            <th>ID</th>
            <th>Dirección Modbus</th>
            <th>Registro</th>
            <th>Descripción</th>
            <th>RW</th>
            <th>Acceso</th>
            <th>Valor</th>
        </tr>";

        // Mostrar datos de la tabla
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
            <td>" . $row["ID"] . "</td>
            <td>" . $row["direccion_modbus"] . "</td>
            <td>" . $row["registro"] . "</td>
            <td>" . $row["descripcion"] . "</td>
            <td>" . $row["rw"] . "</td>
            <td>" . $row["acceso"] . "</td>
            <td>" . $row["valor"] . "</td>
        </tr>";
        }
        echo "</table>";
    } else {
        echo "No se encontraron registros en la tabla.";
    }

    // Cerrar la conexión a la base de datos
    $conn->close();
    ?>
</body>
</html>
