import subprocess
import pymysql

# Conexión a la base de datos MySQL
connection = pymysql.connect(
    host='localhost',
    user='root',
    password='12345678',
    database='circuitor'
)

# Ruta a los scripts
csv_to_sql_script = 'csv_to_sql.py'
update_csv_script = 'update_csv.py'

try:
    while True:
        # Verificar si hay alguna fila con update_flag igual a 0
        cursor = connection.cursor()
        cursor.execute("SELECT COUNT(*) FROM csv_file WHERE update_flag = 0")
        result = cursor.fetchone()
        count = result[0]

        if count == 0:
            print("Todas las filas tienen update_flag igual a 1. Proceso completo.")
            break

        # Ejecutar csv_to_sql.py
        subprocess.run(['python', csv_to_sql_script])

        # Ejecutar update_csv.py
        subprocess.run(['python', update_csv_script])

finally:
    connection.close()
