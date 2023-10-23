<td>Horas de Máquina en producción: </td>    
                    <td><?php echo $horas_operativas;?>       </td>
                </tr>
                <tr>
                    <td>Horas de Máquina parada:        </td>          
                    <td><?php echo $horas_parada;?>     </td>
                <tr>
                <tr>
                    <td>Horas calendario:        </td>          
                    <td><?php echo ($horas_parada+$horas_operativas);?>     </td>
                <tr>
                </tr>
                    <td>Disponibilidad:                 </td>                   
                    <td><?php echo $disp;?>  %          </td>
                </tr>
            