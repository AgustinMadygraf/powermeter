
<ul>
    <li class="<?php echo (basename($_SERVER['PHP_SELF']) == 'index.php')?'active' : ''; ?>">               <a href='index.php'>Ir a Inicio</a>         </li>
    <li class="<?php echo (basename($_SERVER['PHP_SELF']) == 'index.php?table=true')?'active' : ''; ?>">    <a href='index.php?table=true'>Técnico</a>  </li>
    <li class="<?php echo (basename($_SERVER['PHP_SELF']) == 'histograma.php')?'active' : ''; ?>">          <a href='histograma.php' >Histograma</a>    </li>
    <li class="<?php echo (basename($_SERVER['PHP_SELF']) == 'upd_datos_csv_inst.php')?'active' : ''; ?>">  <a href='upd_datos_csv_inst.php' >Upd CSV</a></li>
    <li class="<?php echo (basename($_SERVER['PHP_SELF']) == '')?'active' : 'upd_sql_all_inst.php'; ?>">  <a href='upd_sql_all_inst.php' > Upd SQL</a>                    </li>
    <li class="<?php echo (basename($_SERVER['PHP_SELF']) == '')?'active' : ''; ?>">                        <a href='' >      </a>                      </li>
</ul>
