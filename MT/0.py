import subprocess
import csv
import pymysql
from datetime import datetime
import os
import shutil
import time


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
    archivo_actual = 0

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
        with open('datos.csv', 'r') as file:
            reader = csv.reader(file)
            next(reader)  # Saltar la primera fila (encabezados)

            registro_actual = 0

            for row in reader:
                fecha_string = row[0]
                pot_III = round(float(row[16]) / 1000, 1)
                fecha_datetime = datetime.strptime(fecha_string, "%a %b %d %H:%M:%S %Y")
                unixtime = int(fecha_datetime.timestamp())
                energia = int(float(row[29]))
                v_l1_l2 = int(float(row[20]))
                v_l2_l3 = int(float(row[21]))
                v_l3_l1 = int(float(row[22]))

                # Insertar los valores en la base de datos (evitar duplicados)
                cursor = connection.cursor()
                cursor.execute(
                    "SELECT fecha FROM mt WHERE fecha = %s",
                    (fecha_string,)
                )
                existing_row = cursor.fetchone()

                if existing_row is None:
                    # No hay un registro existente con la misma fecha, realizar la inserción
                    cursor.execute(
                        "INSERT INTO mt (fecha, unixtime, pot_III, energia, v_l1_l2, v_l2_l3, v_l3_l1) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                        (fecha_string, unixtime, pot_III, energia, v_l1_l2, v_l2_l3, v_l3_l1)
                    )
                    connection.commit()
                    registro_actual += 1
                    print(f"Registro insertado correctamente. ({registro_actual}/{count})")
                else:
                    # Ya existe un registro con la misma fecha, omitir la inserción
                    print("Registro duplicado, omitiendo inserción.")
                    break

                cursor.close()

        # Ejecutar update_csv.py
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

            archivo_actual += 1
            print(f"Archivo '{filename}' copiado y renombrado como '{output_filename}'. ({archivo_actual}/{count})")
            print("5")
            time.sleep(1)  # Pausa de 1 segundo
            print("4")
            time.sleep(1)  # Pausa de 1 segundo
            print("3")
            time.sleep(1)  # Pausa de 1 segundo
            print("2")
            time.sleep(1)  # Pausa de 1 segundo
            print("1")
            time.sleep(1)  # Pausa de 1 segundo
            print("0")
            time.sleep(1)  # Pausa de 1 segundo


finally:
    connection.close()
