import csv
import pymysql
from datetime import datetime

# Conexión a la base de datos MySQL
connection = pymysql.connect(
    host='localhost',
    user='root',
    password='12345678',
    database='circuitor'
)

try:
    with open('datos.csv', 'r') as file:
        reader = csv.reader(file)
        next(reader)  # Saltar la primera fila (encabezados)

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
                print("Registro insertado correctamente.")
            else:
                # Ya existe un registro con la misma fecha, omitir la inserción
                print("Registro duplicado, omitiendo inserción.")
                break

            cursor.close()

    print("Proceso completado.")

finally:
    connection.close()
