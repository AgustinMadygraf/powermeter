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

// Obtener valores del formulario
//if (isset($_GET['item']) && isset($_GET['pot_III']) && isset($_GET['unixtime']) && isset($_GET['v_r']) && isset($_GET['v_s']) && isset($_GET['v_t']) ) {

  $item     = $_GET['item'];
  $pot_III  = $_GET['pot_III'];
  $unixtime = $_GET['unixtime'];
  $v_r      = $_GET['v_r'];
  $v_s      = $_GET['v_s'];
  $v_t      = $_GET['v_t'];

 
  
    // Insertar datos en la base de datos
    $sql = "UPDATE `scada` SET  `pot_III` = $pot_III, `unixtime` = $unixtime, `v_r` = $v_r, `v_s` = $v_s, `v_t` = $v_t WHERE `item` = '$item' ";
    echo "SQL = <br>".$sql."<br>respuesta del servidor:<br>";
    if ($conn->query($sql) === TRUE) {
        echo "Los datos  han sido ingresados correctamente en la base de datos";
    } else {
        echo "Error al ingresar datos: " . $conn->error;
    }
  //}


// Cerrar conexión a la base de datos
$conn->close();
?>
<meta http-equiv='refresh' content='0;url=/mediciones/scada/index.php?actualizacion=true'>
