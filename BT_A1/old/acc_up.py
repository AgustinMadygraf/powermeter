import mysql.connector

# Establecer la conexión a la base de datos MySQL
conexion = mysql.connector.connect(
    host="localhost",
    user="root",
    password="12345678",
    database="acc"
)





# Crear un cursor para ejecutar consultas SQL
cursor = conexion.cursor()

# Obtener los datos necesarios para el cálculo de pot_III
consulta = "SELECT `id`, `timestamp`, `III:ea` FROM bt_a1 ORDER BY `timestamp` DESC"
cursor.execute(consulta)
rows = cursor.fetchall()
print("Longitud de la lista: ", len(rows))




# Actualizar el valor de pot_III para cada fila
for i in range(0, len(rows)):
    print()
    current_row = rows[i]
    previous_row = rows[i-1]
    # Calcular la diferencia de energía y tiempo
    energia_diff = current_row[2] - previous_row[2]
    tiempo_diff = current_row[1] - previous_row[1]

    energia_kwh = energia_diff  # Energía en kWh
    tiempo_horas = tiempo_diff / 3600  # Tiempo en horas
    potencia = energia_kwh / tiempo_horas  # Potencia en kW
    potencia = potencia * 1000
    ID = current_row[0]
    
    # Calcular la potencia en kW
    print("potencia: ",potencia)
    print("current_row[0]: ",current_row[0])
    # Actualizar el valor de pot_III en la fila actual
    

    #ID = 24
    #potencia = 100
    update_query = "UPDATE bt_a1 SET pot_III = %s WHERE id = %s"
    print("update_query: ",update_query)

    cursor.execute(update_query, (potencia, ID ))
    


# Confirmar los cambios en la base de datos
conexion.commit()
# Cerrar el cursor y la conexión a la base de datos
cursor.close()
conexion.close()



