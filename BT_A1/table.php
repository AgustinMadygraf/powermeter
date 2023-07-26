<table>    <!-- Tabla con datos y resultados -->
                <tr>
                    <td>A</td>
                    <td>Fecha y hora actual</td>
                    <td><?php echo $unixtimeActual;?></td>
                    <td id="currentDateTime"></td>
                </tr>
                <tr>
                    <td>B</td>
                    <td>Última actualización SQL</td>
                    <td><?php echo $ult_time; ?></td>
                    <td><?php echo date('d-m-Y H:i:s', $ult_time); ?></td>
                </tr>
                <tr> 
                    <td>C</td>
                    <?php echo $msg1;?>
                </tr>
                <tr>
                    <td>D</td>
                    <td>Último dato CSV</td>
                    <td><?php echo $ult_time_csv;?></td>
                    <td><?php echo date('d-m-Y H:i:s',$ult_time_csv) ;?></td>
                </tr>
                <tr>
                <td>A - B</td>
                    <td>Diferencia SQL</td>
                    <td><?php  echo $dif_upd_sql; ?></td>
                    <td><?php  echo $dif_sql; ?></td>
                </tr>
                
                <tr>
                    <td>A - C</td>
                    <td>Diferencia CSV</td>
                    <td><?php  echo $dif_upd_csv; ?> </td> 
                    <td> <?php  echo $dif_csv; ?> </td>
                </tr>
                
                <tr>
                    <td>A - D</td>
                    <td>Diferencia CSV</td>
                    <td><?php echo $dif3_upd_csv;?></td>
                    <td><?php echo $dif_csv3 ;?></td>
                </tr>
                <tr>
                    <td>D - B</td>
                    <td>Diferencia entre CSV y SQL</td>
                    <td><?php echo $dif4_upd_csv;?></td>
                    <td><?php echo $dif_csv4 ;?></td>
                </tr>
            </table>