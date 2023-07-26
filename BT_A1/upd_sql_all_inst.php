


<!DOCTYPE html>
<html>
<head>
    <title>UPD SQL</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <?php require 'header.php'; ?> 
    </header>
    <main>
        <br>
        <br>
        <br>
        <?php require "upd_sql_all_inst2.php"; ?>
        <br>
        <br>
        <br><?php echo date('d-m-Y H:i:s',$unixtime_sql);?>
        <br>
        <form action="procesar_powermeter.php" method="get">
            Unixtime:   <input type="text" name="unixtime"      value=<?php echo $unixtime_sql;?>>     <br>
            Potencia R: <input type="text" name="potencia_r"    value=<?php echo $p_r_sql;?>>     <br>
            Potencia S: <input type="text" name="potencia_s"    value=<?php echo $p_s_sql;?>>     <br>
            Potencia T: <input type="text" name="potencia_t"    value=<?php echo $p_t_sql;?>>     <br>
            Datetime:   <input type="text" name="datetime"      value=<?php echo $fecha_sql;?>>     <br>
            Voltaje R:  <input type="text" name="v_r"           value=<?php echo $v_r_sql;?>>     <br>
            Voltaje S:  <input type="text" name="v_s"           value=<?php echo $v_s_sql;?>>     <br>
            Voltaje T:  <input type="text" name="v_t"           value=<?php echo $v_t_sql;?>>     <br>
                        <input type="submit" value="Guardar">
        </form>
        
        

    </main>
    <footer>
        <?php require "footer.php";?>
    </footer>
</body>
</html>
