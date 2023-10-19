<!-- power_info_display.php -->
<div id="zero" class="hoja" style= <?php echo '"background: linear-gradient(195deg, rgb(107,170,34) '.$d[3].'%, rgb(255,164,1) '.$d[2].'%, rgb(234,53,34) '.$d[1].'%, rgb(100,10,5) '.$d[0].'%);"';//'"background-color:green"'; ?> >
  <div class="info">
    <div class="cabecera">
      <div class="c1">
        <p1><?php echo "Potencia instantánea ".round($potinst,1);?> W</p1>
      </div>
    </div>
        <div id="container" class="graf"></div>
    <?php require "botonera.php"; ?>
  </div>
  <br>
  <br>
  <br>
  <div class='fire' style = <?php   if ($pot>=295) {echo '"background-image: url(\'imagenes/fuego.gif\')";';}   ?> >  </div>
</div>