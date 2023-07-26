import mysql.connector

# Establecer la conexión a la base de datos MySQL
conexion = mysql.connector.connect(
    host="localhost",
    user="root",
    password="12345678",
    database="acc"
)
ID = 21
potencia = 102
# Crear un cursor para ejecutar consultas SQL



cursor = conexion.cursor()

# Definir la consulta de actualización
#update_query = "UPDATE bt_a1 SET pot_III = 250 WHERE ID = 16"
update_query = "UPDATE bt_a1 SET pot_III = %s WHERE id = %s"


# Ejecutar la consulta de actualización
#cursor.execute(update_query)
cursor.execute(update_query, (potencia, ID ))

# Confirmar los cambios en la base de datos
conexion.commit()
# Cerrar el cursor y la conexión a la base de datos
cursor.close()
conexion.close()
