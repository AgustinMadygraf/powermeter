<!DOCTYPE html>
<html>
<head>
    <title>Visualizar datos CSV en tabla</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #f5f5f5;
        }
    </style>
</head>
<body>
    <h1>Datos del archivo CSV</h1>
    <table>
        <tr>
            <th>Fecha</th>
            <th>Timestamp</th>
            <th>R:v</th>
            <th>R:i</th>
            <th>R:p</th>
            <th>R:q</th>
            <th>S:v</th>
            <th>S:i</th>
            <th>S:p</th>
            <th>S:q</th>
            <th>T:v</th>
            <th>T:i</th>
            <th>T:p</th>
            <th>T:q</th>
            <th>Enviar</th>
        </tr>
        <?php
        $file = fopen('datos_inst.csv', 'r');
        if ($file !== false) {
            // Leer la primera línea del archivo CSV (encabezados) y descartarla
            fgetcsv($file);
            // Leer y procesar cada fila del archivo
            while (($row = fgetcsv($file)) !== false) {
                echo '<tr>';
                foreach ($row as $value) {
                    echo '<td>' . $value . '</td>';
                }
                echo '<td> <input type="button" value="enviar"> </td> </tr>';
            }
            fclose($file);
        } else {
            echo '<tr><td colspan="14">Error al abrir el archivo CSV.</td></tr>';
        }
        ?>
    </table>
</body>
</html>
