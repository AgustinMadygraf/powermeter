<?php
function conectarBD()
{
    $server = "localhost";
    $usuario = "root";
    $pass = "12345678";
    $BD = "powermeter";

    $conexion = mysqli_connect($server, $usuario, $pass, $BD);

    if (!$conexion) {
        echo 'Ha sucedido un error inesperado en la conexión de la base de datos<br>';
    }

    return $conexion;
}

function desconectarBD($conexion)
{
    $close = mysqli_close($conexion);

    if (!$close) {
        echo 'Ha sucedido un error inesperado en la desconexión de la base de datos<br>';
    }

    return $close;
}

function ejecutarConsulta($sql)
{
    $conexion = conectarBD();
    $result = mysqli_query($conexion, $sql);

    if (!$result) {
        desconectarBD($conexion);
        return [];
    }

    $rawdata = [];

    while ($row = mysqli_fetch_array($result)) {
        $rawdata[] = $row;
    }

    desconectarBD($conexion);

    return $rawdata;
}

function obtenerPeriodoSeleccionado()
{
    $periodo = 3600;

    if (isset($_GET['periodo'])) {
        switch ($_GET['periodo']) {
            case "hora":
                $periodo = 3600;
                break;
            case "dia":
                $periodo = 86400;
                break;
            case "semana":
                $periodo = 604800;
                break;
            default:
                // Acción a tomar cuando no se cumple ninguna de las condiciones anteriores
                break;
        }
    }

    return $periodo;
}
?>
