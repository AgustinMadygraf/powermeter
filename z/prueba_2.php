<!-- prueba_2.php -->
<!doctype html>  <!-- Consumo actual -->
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<?php
  date_default_timezone_set('America/Argentina/Buenos_Aires');
setlocale(LC_TIME, "spanish");
  $segundos = 60;   // Refrescar cada 60 segundos

  $soundActivo = true;
  if ($_GET){
    if (array_key_exists("mudo",$_GET)){
      $soundActivo = false;
    }
  }
  function vaMudo($conSonido){
    if ($conSonido) {
      return '';
    }
    else {return '?mudo';}
  }



  // Variable que registra que periodo de tiempo mostrar por defecto
  $periodo='dia';
  $ls_periodos=['semana'=>604800000, 'dia'=>88000000, 'hora'=>4600000];
  /*  Complejo sistema de listas q sirve para asignar la clase 'presado'
      al boton correspondiente al periodo q esta seleccionado, y al ibase_resto
      le asigna la clase 'presione', asi se los puede formatear distinto en el css.
  */
  $ls_class=['semana'=>[1,0,0], 'dia'=>[0,1,0], 'hora'=>[0,0,1]];
  $ref_class=['presione', 'presado'];
  $menos_periodo=['semana'=>'dia', 'dia'=>'hora', 'hora'=>'hora'];

  // $mensaje='6';
  if ($_GET){
    if (array_key_exists("periodo", $_GET)){
      if (array_key_exists($_GET["periodo"],$ls_periodos)){
        $periodo = $_GET["periodo"];
      // $mensaje=$ls_periodos[$periodo];
      }
    }
  }
  $class=$ls_class[$periodo];

  /*  Definicion de funciones para interactuar con la base de datos  */
  /*Conectar a la base de datos*/
  function conectarBD(){
      require 'includes/conn.php';
      $BD = "z";
      //variable que guarda la conexi n de la base de datos
      $conexion = mysqli_connect($server, $usuario, $pass, $BD);
      //Comprobamos si la conexi n ha tenido exito
      if(!$conexion){
         echo 'Ha sucedido un error inexperado en la conexion de la base de datos<br>';
      }
      //devolvemos el objeto de conexi n para usarlo en las consultas
      return $conexion;
  }

  /*Desconectar la conexion a la base de datos*/
  function desconectarBD($conexion){
      //Cierra la conexi n y guarda el estado de la operaci n en una variable
      $close = mysqli_close($conexion);
      //Comprobamos si se ha cerrado la conexi n correctamente
      if(!$close){
         echo 'Ha sucedido un error inexperado en la desconexion de la base de datos<br>';
      }
      //devuelve el estado del cierre de conexi n
      return $close;
  }

  //Devuelve un array multidimensional con el resultado de la consulta
  function getArraySQL($sql){
      //Creamos la conexi n
      $conexion = conectarBD();
      //generamos la consulta
      if(!$result = mysqli_query($conexion, $sql)) die();

      $rawdata = array();
      //guardamos en un array multidimensional todos los datos de la consulta
      $i=0;
      while($row = mysqli_fetch_array($result))
      {
          //guardamos en rawdata todos los vectores/filas que nos devuelve la consulta
          $rawdata[$i] = $row;
          $i++;
      }

      //Cerramos la base de datos
      desconectarBD($conexion);
      //devolvemos rawdata
      return $rawdata;
  }



function sql_query($where_medidor, $campo){
    return "SELECT `time`, `{$campo}` FROM `potencia registrada` WHERE `medidor`{$where_medidor} ORDER BY `time` DESC LIMIT 16";
  }
  if ($_GET and array_key_exists("medidor", $_GET)) {
    $medidor = $_GET["medidor"];
  } else {
    $medidor = "default";
  }
  $where_medidor = ($medidor!="default"?'="'.$medidor.'"':" is NULL");
  $res = getArraySQL(sql_query($where_medidor, "energia"));
  $pot1= $res[0]['energia'];
  $pot2= $res[15]['energia'];
  $pot15 = $pot1-$pot2;
  $pot15 = $pot15*4;
  $pot15 = $pot15/100;
  $pot15 = round($pot15);
  $pot15 = $pot15/10;
  $pot= $pot15;
  $res = getArraySQL(sql_query($where_medidor, "potencia"));
  $potinst= $res[0]['potencia'];



//20/12/2021
//leemos archivo de texto con valor de sp y tiempo de permanencia
//ver de colcoarlo para que lo lea solo una vez, n en forma continua

$fp=fopen("setup.csv","r");
$linea=fgets($fp);
fclose($fp);

//Separo Sp y Td

$dect=explode(",",$linea);
echo $dect[0];
echo $dect[1];






  /*$pot= 750;*/
  $unixtime =$res[0]['time']/1000;


 //20/12/2021
  $alarma1_pot=0;

  if ((intval($pot) > intval($dect[0]) )) {
  $alarma1_pot=1;


  }
 else {
   $alarma1_pot=0;
}




  $unaesc=0;
  $ordencorte_1=1;

  if ((intval($pot) > intval($dect[0]) ) and ($ordencorte_1) and !($unaesc) ) {
  $alarma1_pot=1;

  $archivonombre='c:\\repositorio\\'."orden.txt";
  $f=fopen($archivonombre,"w+");



         $linea=$alarma1_pot."\r\n";
        try {
        fwrite($f,$linea);

        } catch (Exception $ex) {
             echo '<script langage="javascript">alert("Error de escritura");</script>';
        }
        $unaesc=1;

// echo '<script langage="javascript">alert("Se ha realizado la exportación");</script>';
        fclose($f);



  }



if ((intval($pot) < intval($dect[0]) ) and ($ordencorte_1) and !($unaesc) ) {
  $alarma1_pot=0;

  $archivonombre=$archivonombre='c:\\repositorio\\'."orden.txt";
  $f=fopen($archivonombre,"w+");



         $linea=$alarma1_pot.$separador."\r\n";
        try {
        fwrite($f,$linea);

        } catch (Exception $ex) {
             echo '<script langage="javascript">alert("Error de escritura");</script>';
        }
        $unaesc=1;

// echo '<script langage="javascript">alert("Se ha realizado la exportación");</script>';
        fclose($f);



  }









  if ($pot > 292 ) {
    if ($potinst > 299 ) {
      $segundos = 54;   // Refrescar cada 187 segundos el tiempo que funciona la alarma
      echo " <audio src='archivos/alert-1.mp3' autoplay> </audio>";
    }



  }

  /* Si la variable 'test' aparece en $_GET el refresco
     se hace cada segund en vez de cada 20 segundos.    */

  header("Refresh:".$segundos);






  // Valores para la ubicacion del degrade de advertencia
  $d=array();
  for ($i=0; $i<4; $i++){
    $d[$i]=350-$pot-10*$i;
  }

  $date = date(DATE_RFC2822);
  $newDate = date("D, d M Y".(" 00:00:00")." O");

  $valorInicial = $unixtime*1000;//-$ls_periodos[$periodo];
  $conta = $valorInicial;
  if ($_GET){
    if (array_key_exists("conta", $_GET)){
        $conta = $_GET["conta"];
        if ($conta > $valorInicial) {$conta = $valorInicial;}
    }
  }
  /* Cuando se piden datos a SQL se piden los que tienen tiempos
      entre $tiempo1 y $tiempo2 de forma que empiezen en $conta y
      abarquen el periodo de segundos dado por $ls_periodos[$periodo] */
  $tiempo1=$conta-$ls_periodos[$periodo];
  $tiempo2=$conta+ 16 * 60 *1000;
  //Sentencia SQL
  $sql = "SELECT `time`, `potencia`,`pot15`, `contratada` from `potencia registrada` WHERE `medidor` ".$where_medidor." AND time > ".$tiempo1." and time <= ".$tiempo2.";";
  //Array Multidimensional
  $rawdata = getArraySQL($sql);



  $medidor_query = "SELECT DISTINCT(medidor) FROM `potencia registrada`;";
  $medidor_options = getArraySQL($medidor_query);
  echo '<ul>';
  foreach ($medidor_options as $medidor_it) {
    $medidor_option=($medidor_it[0]==null?"default":$medidor_it[0]);
    echo '<li><a  href='.$_SERVER["PHP_SELF"].'?medidor='.$medidor_option.'&periodo=semana><button>
    '.$medidor_option.'
    </button></a></li>';
  }
  echo '</ul>';

?>

      <a name="TOP"></a>

      <!-- Este es el fondo en degrade que se actualiza segun el valor de la potencia -->
      <div id="zero" class="hoja" style= <?php echo '"background: linear-gradient(195deg, rgb(107,170,34) '.$d[3].'%, rgb(255,164,1) '.$d[2].'%, rgb(234,53,34) '.$d[1].'%, rgb(100,10,5) '.$d[0].'%);"';//'"background-color:green"'; ?> >
        <div class="info">
          <div class="cabecera">
              <div class="c1">

<?php
$costo = round($pot*1.36*14.648,2);
$costo2 = round($pot*1.36*4.702,2);
$CO2 = round($pot*0.36,2);
?>
                  <p1><?php echo "Potencia instantánea ".round($potinst,1);?> kW</p1>
                  <p1><?php echo "$".$costo;?> por hora [Tarifa gran usuario GUDI] </p1>
                  <p1><?php echo "$".$costo2;?> por hora [Tarifa T3 menor 300kW] </p1>
                  <p2><?php echo " ".round($CO2,1);?> kilos de CO2 por hora</p2>




              </div>
          </div>
          <div class="dataspace">
              <!-- En este div se inserta el grafico de los datos de $rowdata -->
              <div id="container" class="graf"></div>
          </div>
          <!--Botonera ubicada bajo el grafico para navegar los datos -->
          <div class="botonera">

              <form action="<?=$_SERVER["PHP_SELF"].'?medidor='.$medidor.'&periodo='.$periodo.'&conta='.($conta - $ls_periodos[$periodo]).vaMudo($soundActivo)?>" method="post" class="botonI">
                  <input type="submit" value=<?php echo $periodo.'_anterior'; ?> class="presione">
              </form>

              <div class='spacer'></div>

              <form action="<?=$_SERVER["PHP_SELF"].'?medidor='.$medidor.'&periodo=semana&conta='.$conta.vaMudo($soundActivo)?>" method="post" class="periodo">
                  <input type="submit" value="semana" class=<?=$ref_class[$class[0]];?>>
              </form>

              <form action="<?=$_SERVER["PHP_SELF"].'?medidor='.$medidor.'&periodo=dia&conta='.$conta.vaMudo($soundActivo)?>" method="post" class="periodo">
                  <input type="submit" value="dia" class=<?=$ref_class[$class[1]];?>>
              </form>

              <form action="<?=$_SERVER["PHP_SELF"].'?medidor='.$medidor.'&periodo=hora&conta='.$conta.vaMudo($soundActivo)?>" method="post" class="periodo">
                  <input type="submit" value="hora" class=<?=$ref_class[$class[2]];?>>
              </form>

              <div class='spacer'></div>

              <form  action="<?=$_SERVER["PHP_SELF"].'?medidor='.$medidor.'&periodo='.$periodo.'&conta='.($conta + $ls_periodos[$periodo]).vaMudo($soundActivo)?>" method="post" class="botonD">
                  <input type="submit" value=<?php echo $periodo.'_siguiente'; ?> class="presione">
              </form>

              <form  action="<?=$_SERVER["PHP_SELF"].'?medidor='.$medidor.'&periodo='.$periodo.vaMudo($soundActivo)?>" method="post" class="fin">
                  <input type="submit" value='>|' class="presione">
              </form>

          </div>


        </div>
        <!-- En este contenedor se enciende el gif de advertencia cuando la potencia supera los 650 kW -->
        <div class='fire' style = <?php   if ($pot>=300) {echo '"background-image: url(\'imagenes/fuego.gif\')";';}   ?> >  </div>
        <!-- Boton test -->
        <?php $t='?test'; if ($_GET){ if(array_key_exists('test',$_GET)){$t='';}} ?>

      </div>
      <!-- Todo el script siguient se encarga de tomar los datos de la lista $rawdata
      y dibujar la grafica que va insertada en el div id="container"            -->
      <script type='text/javascript'>

        var doubleClicker = {
          clickedOnce: false,
          timer: null,
          timeBetweenClicks: 400
        };

        var resetDoubleClick = function() {
          clearTimeout(doubleClicker.timer);
          doubleClicker.timer = null;
          doubleClicker.clickedOnce = false;
        };

        var zoomIn = function(event) {
          var tiempo = Highcharts.numberFormat(event.xAxis[0].value+<?= $ls_periodos[$menos_periodo[$periodo]]/2 ?>);
          window.open("<?=$_SERVER["PHP_SELF"].'?medidor='.$medidor.'&periodo='.$menos_periodo[$periodo].'&conta='?>"+tiempo+"<?= vaMudo($soundActivo)?>","_self")
        };

        var ondbclick = function(event) {
          if (doubleClicker.clickedOnce === true && doubleClicker.timer) {
            resetDoubleClick();
            zoomIn(event);
          } else {
            doubleClicker.clickedOnce = true;
            doubleClicker.timer = setTimeout(function(){
              resetDoubleClick();
            }, doubleClicker.timeBetweenClicks);
          }
        };

        $(function () {
            Highcharts.setOptions({
                global: {
                    useUTC: false
                },
                lang: {
                  thousandsSep: "",
                  months: [
                      'Enero', 'Febrero', 'Marzo', 'Abril',
                      'Mayo', 'Junio', 'Julio', 'Agosto',
                      'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
                  ],
                  weekdays: [
                      'Domingo', 'Lunes', 'Martes', 'Miercoles',
                      'Jueves', 'Viernes', 'Sabado'
                  ]
                }
            });

            var chart;
            $('#container').highcharts({
                chart: {
                    type: 'spline',
                    animation: false, //Highcharts.svg, // don't animate in old IE
                    marginRight: 10,
                    events: {
                        load: function() {

                        },
                        click: function(event) {
                          ondbclick (event);
                        }
                    }
                },
                title: {
                    text: (function() {
                       return Highcharts.dateFormat("%A, %d %B %Y - %H:%M:%S", <?php echo $conta; ?>)
                    })(),
                    events: {
                        load: function() {

                        },
                        click: function(event) {
                          ondbclick (event);
                        }

                    }
                },
                xAxis: {
                    type: 'datetime',
                    tickPixelInterval: 1
                },
                yAxis: {
                    title: {
                        text: '[KiloWatts]'
                    },
                    plotLines: [{
                        value: 0,
                        width: 1,
                        color: '#808080'
                    }]
                },
                tooltip: {
                    formatter: function() {
                            return '<b>'+ this.series.name +'</b><br/>'+
                            Highcharts.dateFormat("%A, %d %B %Y - %H:%M:%S", this.x) +'<br/>'+
                            Highcharts.numberFormat(this.y, 1)+' kW';
                    }
                },
                legend: {
                    enabled: true
                },
                exporting: {
                    enabled: true
                },
                series: [

                  {
                    name: 'Potencia Adquirida instantánea',
                    animation: false,
                    data: (function() {
                       var data = [];
                        <?php for($i = 15 ;$i  <count($rawdata);$i++)
                        { echo " data.push([ ".$rawdata[$i]["time"].",".$rawdata[$i]["potencia"] ."]);"; }  ?>
                    return data;
                    })()
                },



                {
                  name: 'Potencia contratada',
                  animation: false,
                  data: (function() {
                     var data = [];
                      <?php for($i = 15 ;$i  <count($rawdata);$i++)
                      { echo " data.push([ ".$rawdata[$i]["time"].",".$rawdata[$i]["contratada"] ."]);"; }  ?>
                  return data;
                  })()
              },








              {
                name: 'Potencia Adquirida 15 min',
                animation: false,
                data: (function() {
                   var data = [];
                    <?php for($i = 15 ;$i  <count($rawdata);$i++)
                    { echo " data.push([ ".$rawdata[$i]["time"].",".$rawdata[$i]["pot15"] ."]);"; }  ?>
                return data;
                })()
            },



              ]
            });
        });
      </script>

      <br>
    </div>
