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

if (isset($_GET['unixtime']) && isset($_GET['potencia_r']) && isset($_GET['potencia_s']) && isset($_GET['potencia_t']) ) {
  $unixtime = $_GET['unixtime'];
  $potencia_r = $_GET['potencia_r'];
  $potencia_s = $_GET['potencia_s'];
  $potencia_t = $_GET['potencia_t'];
  $potencia_r = $potencia_r/1000 ;
  $potencia_s = $potencia_s/1000 ;
  $potencia_t = $potencia_t/1000 ;
  $v_r = $_GET['v_r'];
  $v_s = $_GET['v_s'];
  $v_t = $_GET['v_t'];

  // Verificar si ya existe un registro con el mismo valor de unixtime
  $sql = "SELECT * FROM BT_B WHERE unixtime = '$unixtime'";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    echo "El registro unixtime = $unixtime ya existe en la base de datos.";
  } else {
    // Insertar datos en la base de datos
    $sql = "INSERT INTO BT_B (unixtime, potencia_r, potencia_s, potencia_t, v_r, v_s, v_t) VALUES ('$unixtime', '$potencia_r', '$potencia_s', '$potencia_t', '$v_r', '$v_s', '$v_t' )";

    if ($conn->query($sql) === TRUE) {
        echo "Los datos  Pot R: ".$potencia_r."; Pot S: ".$potencia_s."; Pot T: ".$potencia_t."; V R: ".$v_r."; V S: ".$v_s."; V T: ".$v_t."; unixtime ".$unixtime."  han sido ingresados correctamente en la base de datos";
    } else {
        echo "Error al ingresar datos: " . $conn->error;
    }
  }
}

// Cerrar conexión a la base de datos
$conn->close();
?>