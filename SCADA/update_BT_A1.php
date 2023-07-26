<?php 
    
    function conectarBD()
        {  $server = "localhost";
            $usuario = "root";
            $pass = "12345678";
            $BD = "powermeter";
            //variable que guarda la conexi�n de la base de datos
            $conexion = mysqli_connect($server, $usuario, $pass, $BD);
            //Comprobamos si la conexi�n ha tenido exito
            if(!$conexion){ echo 'Ha sucedido un error inexperado en la conexion de la base de datos<br>'; }
            //devolvemos el objeto de conexi�n para usarlo en las consultas
            return $conexion;
        }
    
    function desconectarBD($conexion)
        { //Cierra la conexi�n y guarda el estado de la operaci�n en una variable
            $close = mysqli_close($conexion);
            //Comprobamos si se ha cerrado la conexi�n correctamente
            if(!$close){ echo 'Ha sucedido un error inexperado en la desconexion de la base de datos<br>'; }
            //devuelve el estado del cierre de conexi�n
            return $close;
        }
    function getArraySQL($sql)
        {//Creamos la conexi�n
        $conexion = conectarBD();
        //generamos la consulta
        if(!$result = mysqli_query($conexion, $sql)) die();
        $rawdata = array();
        //guardamos en un array multidimensional todos los datos de la consulta
        $i=0;
        while($row = mysqli_fetch_array($result))
            {   //guardamos en rawdata todos los vectores/filas que nos devuelve la consulta
                $rawdata[$i] = $row;
                $i++;
                }
        //Cerramos la base de datossssss
        desconectarBD($conexion);
        //devolvemos rawdata
        return $rawdata;
        }

    
    $sql = "SELECT `unixtime`, `potencia_III`, `v_r`, `v_s`, `v_t` FROM `BT_A1`  ORDER BY `BT_A1`.`unixtime` DESC  ";
    //Array Multidimensional
    echo "sql = <br>".$sql."<br.>";
    $rawdata = getArraySQL($sql);
    $pot_III_BT_A1 = $rawdata[0]["potencia_III"];
    $unixtime_BT_A1 = $rawdata[0]["unixtime"];
    $v_r_BT_A1 = $rawdata[0]["v_r"];
    $v_s_BT_A1 = $rawdata[0]["v_s"];
    $v_t_BT_A1 = $rawdata[0]["v_t"];
    echo "<br>pot_III_BT_A1 = ".$pot_III_BT_A1;
    echo "<br>unixtime_BT_A1 = ".$unixtime_BT_A1;
    echo "<br>v_r_BT_A1 = ".$v_r_BT_A1;
    echo "<br>v_s_BT_A1 = ".$v_s_BT_A1;
    echo "<br>v_t_BT_A1 = ".$v_t_BT_A1;
    
?>

<meta http-equiv='refresh' content='0;url=/mediciones/scada/procesar_scada.php?item=POT_BT_A1&pot_III=<?php echo $pot_III_BT_A1?>&unixtime=<?php echo $unixtime_BT_A1?>&v_r=<?php echo $v_r_BT_A1?>&v_s=<?php echo $v_s_BT_A1?>&v_t=<?php echo $v_r_BT_A1?>'>