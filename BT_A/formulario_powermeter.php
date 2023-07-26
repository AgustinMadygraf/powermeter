<?php
// Conectarse a la base de datos
$servername = "localhost";
$username = "root";
$password = "12345678";
$dbname = "powermeter";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
  die("Error de conexión: " . $conn->connect_error);
}

// Guardar los valores en la tabla
if (isset($_GET['unixtime']) && isset($_GET['potencia_s']) && isset($_GET['potencia_r']) && isset($_GET['potencia_t']) ) {
  $unixtime = $_GET['unixtime'];
  $potencia_s = $_GET['potencia_s'];
  $potencia_r = $_GET['potencia_r'];
  $potencia_t = $_GET['potencia_t'];

  $sql = "INSERT INTO BT_A (unixtime, potencia_s, potencia_r, potencia_t)
  VALUES ('$unixtime', '$potencia_s', '$potencia_r', '$potencia_t')";

  if ($conn->query($sql) === TRUE) {
    echo "Datos guardados correctamente";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
}

$conn->close();
?>

<html>
<body>
  <form action="procesar_powermeter.php" method="get">
    Unixtime: <input type="text" name="unixtime"><br>
    Potencia S: <input type="text" name="potencia_s"><br>
    Potencia R: <input type="text" name="potencia_r"><br>
    Potencia T: <input type="text" name="potencia_t"><br>
    <input type="submit" value="Guardar">
  </form>
</body>
</html>
