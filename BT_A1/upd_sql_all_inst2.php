
<?php   
    require 'conn.php';  
    // Ruta del archivo CSV
    $csvFile = 'datos_inst.csv';
    $diff4 = $dif4_upd_csv/300; // Cantidad de registros que deseas mostrar
    $diff4 = 2 ;

    // Función para obtener los datos del archivo CSV y ordenarlos por "timestamp" de mayor a menor
    function getSortedCSVData($csvFile)
    {
        $data = array();

        if (($handle = fopen($csvFile, "r")) !== FALSE) {
            // Saltar la primera línea (cabecera)
            fgetcsv($handle);

            while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
                // Convertir el campo "timestamp" a número para facilitar la ordenación
                $row[1] = intval($row[1]);
                $data[] = $row;
            }
            fclose($handle);
        }

        // Ordenar los datos por "timestamp" de mayor a menor
        usort($data, function($a, $b) {
            return $b[1] - $a[1];
        });

        return $data;
    }


    // Obtener los datos ordenados del archivo CSV
    $sortedData = getSortedCSVData($csvFile);


    $i = $diff4-2;
    $fecha_sql = $sortedData[$i][0]; // Fecha
    $unixtime_sql =  $sortedData[$i][1]; // Timestamp
    $v_r_sql = $sortedData[$i][2]; // R:v
    $i_r_sql = $sortedData[$i][3]; // R:i
    $p_r_sql = $sortedData[$i][4]; // R:p
    $q_r_sql = $sortedData[$i][5]; // R:q
    $v_s_sql = $sortedData[$i][6]; // S:v
    $i_s_sql = $sortedData[$i][7]; // S:i
    $p_s_sql = $sortedData[$i][8]; // S:p
    $q_s_sql = $sortedData[$i][9]; // S:q
    $v_t_sql = $sortedData[$i][10]; // T:v
    $i_t_sql = $sortedData[$i][11]; // T:i
    $p_t_sql = $sortedData[$i][12]; // T:p
    $q_t_sql = $sortedData[$i][13]; // T:q
        echo '</tr>';


    echo '</table>';


?>