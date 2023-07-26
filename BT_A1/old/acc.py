import csv
import mysql.connector
import math

# Establecer la conexión a la base de datos MySQL
conexion = mysql.connector.connect(
    host="localhost",
    user="root",
    password="12345678",
    database="acc"
)

# Crear un cursor para ejecutar consultas SQL
cursor = conexion.cursor()

# Definir la consulta SQL para insertar datos en la tabla
consulta = "INSERT INTO bt_a1 (`timestamp`, `R:ea`, `R:er`, `S:ea`, `S:er`, `T:ea`, `T:er`) VALUES (%s, %s, %s, %s, %s, %s, %s)"

# Leer el archivo CSV y ordenar los datos por timestamp descendente
with open('datos_acc.csv', newline='') as csvfile:
    reader = csv.DictReader(csvfile)
    sorted_rows = sorted(reader, key=lambda row: int(row['timestamp']), reverse=True)
    
    # Obtener el total de filas del archivo CSV
    total_rows = len(sorted_rows)
    
    # Iterar sobre las filas del archivo CSV ordenadas
    for index, row in enumerate(sorted_rows):
        # Obtener los valores de cada columna
        timestamp = int(row['timestamp'])
        r_ea = row['R:ea']
        r_er = row['R:er']
        s_ea = row['S:ea']
        s_er = row['S:er']
        t_ea = row['T:ea']
        t_er = row['T:er']
        
        # Realizar la operación en el valor de timestamp
        timestamp = round(timestamp / 60) * 60
        
        # Ejecutar la consulta para insertar los datos de cada fila
        cursor.execute(consulta, (timestamp, r_ea, r_er, s_ea, s_er, t_ea, t_er))
        
        # Imprimir el progreso de la ejecución
        print(f"Procesando fila {index + 1} de {total_rows}")
        
# Confirmar los cambios en la base de datos
conexion.commit()

# Cerrar el cursor y la conexión a la base de datos
cursor.close()
conexion.close()
