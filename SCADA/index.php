
<!DOCTYPE html>
<html>
<head>
<?php 
  function conectarBD(){  $server = "localhost";
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
  
  function desconectarBD($conexion){ //Cierra la conexi�n y guarda el estado de la operaci�n en una variable
                                      $close = mysqli_close($conexion);
                                      //Comprobamos si se ha cerrado la conexi�n correctamente
                                      if(!$close){ echo 'Ha sucedido un error inexperado en la desconexion de la base de datos<br>'; }
                                      //devuelve el estado del cierre de conexi�n
                                      return $close;
                                    }
  function getArraySQL($sql){
                              //Creamos la conexi�n
                              $conexion = conectarBD();
                              //generamos la consulta
                              if(!$result = mysqli_query($conexion, $sql)) die();
                              $rawdata = array();
                              //guardamos en un array multidimensional todos los datos de la consulta
                              $i=0;
                              while($row = mysqli_fetch_array($result)){ //guardamos en rawdata todos los vectores/filas que nos devuelve la consulta
                                                                          $rawdata[$i] = $row;
                                                                          $i++;
                                                                        }
                              //Cerramos la base de datossssss
                              desconectarBD($conexion);
                              //devolvemos rawdata
                              return $rawdata;
                          }
  
  
	$sql = "SELECT `datetime`, `pot_III`, `v_r`, `v_s`, `v_t` FROM `scada` ";
	//Array Multidimensional
	//echo "sql = <br>".$sql."<br.>";
	$rawdata = getArraySQL($sql);

	$pot_III_BT_A	= $rawdata[1]["pot_III"];
	$datetime_BT_A	= $rawdata[1]["datetime"];
	$v_r_BT_A 		= $rawdata[1]["v_r"];
	$v_s_BT_A 		= $rawdata[1]["v_s"];
	$v_t_BT_A 		= $rawdata[1]["v_t"];

	$pot_III_BT_A1	= $rawdata[3]["pot_III"];
	$datetime_BT_A1 = $rawdata[3]["datetime"];
	$v_r_BT_A1 		= $rawdata[3]["v_r"];
	$v_s_BT_A1 		= $rawdata[3]["v_s"];
	$v_t_BT_A1 		= $rawdata[3]["v_t"];
		
	$pot_III_BT_B 	= $rawdata[5]["pot_III"];
	$datetime_BT_B	= $rawdata[5]["datetime"];
	$v_r_BT_B 		= $rawdata[5]["v_r"];
	$v_s_BT_B 		= $rawdata[5]["v_s"];
	$v_t_BT_B 		= $rawdata[5]["v_t"];
		
	$pot_III_BT_B1 	= $rawdata[5]["pot_III"];
	$datetime_BT_B1 = $rawdata[5]["datetime"];
	$v_r_BT_B1 		= $rawdata[5]["v_r"];
	$v_s_BT_B1 		= $rawdata[5]["v_s"];
	$v_t_BT_B1 		= $rawdata[5]["v_t"];

	$actualizacion = $_GET['actualizacion'];

	if ($actualizacion === 'true') {
		$segundos = 60;
	} else {
		$segundos = 0;
	}

?>

	<title>SCADA</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
		<h1>SCADA</h1>
		<h4>supervisión, control y adquisición de datos eléctricos</h4>
		<div class="container">
			<div class="duplicate">
				<div class="container">
					<div class='box'>
					<h3><a href="/mediciones/MT">Cámara de Media Tensión</h3>
						<h3>Edenor</a></h3>
						<p><br></p>
						<p>Valor: <?php echo $pot_III_MT;?> kW</p>
						<p>Fecha y Hora:</p>
						<p><?php echo $datetime_MT;?></p><br>
						<p>Voltaje fase R: <?php echo $v_r_MT;?></p>
						<p>Voltaje fase S: <?php echo $v_s_MT;?></p>
						<p>Voltaje fase T: <?php echo $v_t_MT;?></p>	
						<div class="container">
					<div class='box'>
					<h3><a href="/mediciones/BT_A">Subestación transformadora</h3>
						<h3>A&C</a></h3>
						<p><br></p>
						<p>Valor: <?php echo $pot_III_BT_A;?> kW</p>
						<p>Fecha y Hora:</p>
						<p><?php echo $datetime_BT_A;?></p><br>
						<p>Voltaje fase R: <?php echo $v_r_BT_A;?></p>
						<p>Voltaje fase S: <?php echo $v_s_BT_A;?></p>
						<p>Voltaje fase T: <?php echo $v_t_BT_A;?></p>	
						<div class="container">
							<div class='box'>
								<h3><a href="/mediciones/BT_A1">Maq de bolsas</a></h3>
								<p>Valor: <?php echo $pot_III_BT_A1;?> kW</p>
								<p>Fecha y Hora:</p>
								<p><?php echo $datetime_BT_A1;?></p><br>
								<p>Voltaje fase R: <?php echo $v_r_BT_A1;?></p>
								<p>Voltaje fase S: <?php echo $v_s_BT_A1;?></p>
								<p>Voltaje fase T: <?php echo $v_t_BT_A1;?></p>																
							</div>
							<div class='box'>
								<h3>M300-1; compresores; Hitachi; Iluminación</h3>
								<p>Valor: 95</p>
								<p>Fecha y Hora:</p>
								<p>0000-00-00 00:00:00</p>
							</div>
						</div>
					</div>
					<div class='box'>
						<h3><a href="/mediciones/BT_B">Subestación transformadora</a></h3>
						<h3><a href="/mediciones/BT_B">EASA</a></h3>
						<p><br></p>
						<p>Valor: <?php echo $pot_III_BT_B;?> kW</p>
						<p>Fecha y Hora:</p>
						<p><?php echo $datetime_BT_B;?></p><br>
						<p>Voltaje fase R: <?php echo $v_r_BT_B;?></p>
						<p>Voltaje fase S: <?php echo $v_s_BT_B;?></p>
						<p>Voltaje fase T: <?php echo $v_t_BT_B;?></p>
						<div class="container">
							<div class='box'>
								<h3>WorldColor</h3>
								<p>Valor: <?php echo $pot_III_BT_B1;?> kW</p>
								<p>Fecha y Hora:</p>
								<p><?php echo $datetime_BT_B1;?></p><br>
								<p>Voltaje fase R: <?php echo $v_r_BT_B1;?></p>
								<p>Voltaje fase S: <?php echo $v_s_BT_B1;?></p>
								<p>Voltaje fase T: <?php echo $v_t_BT_B1;?></p>																
							</div>					

					<div class='box'>
						<h3>M1000 Beiren</h3>
								<p>Valor: <?php echo $pot_III_BT_B2;?> kW</p>
								<p>Fecha y Hora:</p>
								<p><?php echo $datetime_BT_B2;?></p><br>
								<p>Voltaje fase R: <?php echo $v_r_BT_B2;?></p>
								<p>Voltaje fase S: <?php echo $v_s_BT_B2;?></p>
								<p>Voltaje fase T: <?php echo $v_t_BT_B2;?></p>	
					</div>

					<div class='box'>
						<h3>Carrier, compresores, iluminación</h3>
						<p>Valor: 105</p>
						<p>Fecha y Hora:</p>
						<p>0000-00-00 00:00:00</p>
					</div>					
					</div>
					</div>
				</div>
					</div>
				</div>


				<meta http-equiv='refresh' content='<?php echo $segundos;?>;url=/mediciones/scada/update.php'>
				<br>
				<a href="/index2.php" target="_blank">AppServ</a>

		
</body>
</html>
