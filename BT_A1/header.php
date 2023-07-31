<?php
    if (isset($_GET['disp']) && $_GET['disp'] > 0 ) { $disp = $_GET['disp'];}

?>
<ul>
    <li class="<?php echo (basename($_SERVER['PHP_SELF']) == 'index.php'                )?'active' : ''; ?>"><a href='index.php'>               Ir a Inicio </a></li>
    <li class="<?php echo (basename($_SERVER['PHP_SELF']) == 'index.php?table=true'     )?'active' : ''; ?>"><a href='index.php?table=true'>    Técnico     </a></li>
    <li class="<?php echo (basename($_SERVER['PHP_SELF']) == 'histograma.php'           )?'active' : ''; ?>"><a href='histograma.php' >         Histograma  </a></li>
    <li class="<?php echo (basename($_SERVER['PHP_SELF']) == 'upd_datos_csv_inst.php'   )?'active' : ''; ?>"><a href='upd_datos_csv_inst.php' > Upd CSV     </a></li>
    <li class="<?php echo (basename($_SERVER['PHP_SELF']) == 'upd_sql_all_inst.php'     )?'active' : ''; ?>"><a href='upd_sql_all_inst.php' >   Upd SQL     </a></li>
    <li class="<?php echo (basename($_SERVER['PHP_SELF']) == 'OEE.php'                  )?'active' : ''; ?>"><a href='OEE.php?disp=<?php echo $disp;?>' >                OEE         </a></li>
    <li class="<?php echo (basename($_SERVER['PHP_SELF']) == 'promedio.php'             )?'active' : ''; ?>"><a href='promedio.php' >           Promedio    </a></li> 
</ul>
