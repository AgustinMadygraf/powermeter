import os
import pymysql

# Conexión a la base de datos MySQL
connection = pymysql.connect(
    host='localhost',
    user='root',
    password='12345678',
    database='circuitor'
)

# Directorio de archivos CSV
csv_directory = 'C:\\AppServ\\www\\mediciones\\MT\\CSV'

try:
    # Obtener lista de archivos CSV en el directorio
    csv_files = [file for file in os.listdir(csv_directory) if file.endswith('.csv')]

    # Insertar los nombres de los archivos en la tabla csv_file
    cursor = connection.cursor()
    for filename in csv_files:
        cursor.execute("INSERT INTO csv_file (filename, update_flag) VALUES (%s, %s)", (filename, False))
    connection.commit()

    print("Archivos CSV subidos a la base de datos correctamente.")

finally:
    connection.close()
