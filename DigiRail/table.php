<!-- table.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Tabla de Registros Modbus</title>
</head>
<body>
    <h2>Tabla de Registros Modbus</h2>
    <table border='1' id="data-table">
        <tr>
            <th>ID</th>
            <th>Dirección Modbus</th>
            <th>Registro</th>
            <th>Descripción</th>
            <th>RW</th>
            <th>Acceso</th>
            <th>Valor</th>
        </tr>
    </table>
    <script>
        function updateTable() {
            // Utilizar AJAX para hacer una solicitud al servidor y obtener datos actualizados
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState === 4 && this.status === 200) {
                    // Procesar la respuesta y actualizar la tabla
                    var data = JSON.parse(this.responseText);
                    var table = document.getElementById("data-table");
                    table.innerHTML = ""; // Limpiar la tabla

                    // Reconstruir la tabla con los datos actualizados
                    for (var i = 0; i < data.length; i++) {
                        var row = table.insertRow(i + 1); // +1 para omitir la fila de encabezado
                        row.insertCell(0).innerHTML = data[i].ID;
                        row.insertCell(1).innerHTML = data[i].direccion_modbus;
                        row.insertCell(2).innerHTML = data[i].registro;
                        row.insertCell(3).innerHTML = data[i].descripcion;
                        row.insertCell(4).innerHTML = data[i].rw;
                        row.insertCell(5).innerHTML = data[i].acceso;
                        row.insertCell(6).innerHTML = data[i].valor;
                    }
                }
            };
            xhttp.open("GET", "obtener_datos.php", true); // Reemplaza "obtener_datos.php" con la URL de tu script de servidor
            xhttp.send();
        }

        // Actualizar la tabla cada 200 milisegundos
        setInterval(updateTable, 200);
    </script>
</body>
</html>
