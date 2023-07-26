import os
import shutil
import pymysql

# Conexión a la base de datos MySQL
connection = pymysql.connect(
    host='localhost',
    user='root',
    password='12345678',
    database='circuitor'
)

# Directorio de archivos CSV
csv_directory = 'C:\AppServ\www\CSV'
output_directory = 'C:\\AppServ\\www\\mediciones\\MT'
output_filename = 'datos.csv'

try:
    # Buscar el primer CSV con update_flag igual a 0
    cursor = connection.cursor()
    cursor.execute("SELECT filename FROM csv_file WHERE update_flag = 0 LIMIT 1")
    result = cursor.fetchone()
    if result is None:
        print("No se encontraron archivos CSV para actualizar.")
    else:
        filename = result[0]

        # Copiar el archivo CSV al directorio de salida y renombrarlo
        source_path = os.path.join(csv_directory, filename)
        destination_path = os.path.join(output_directory, output_filename)
        shutil.copyfile(source_path, destination_path)

        # Actualizar el valor de update_flag a 1 en la tabla csv_file
        cursor.execute("UPDATE csv_file SET update_flag = 1 WHERE filename = %s", (filename,))
        connection.commit()

        print(f"Archivo '{filename}' copiado y renombrado como '{output_filename}'.")

finally:
    connection.close()
