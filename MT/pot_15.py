import mysql.connector
from mysql.connector import pooling

# Configuración de la piscina de conexiones
dbconfig = {
    "host": "localhost",
    "user": "root",
    "password": "12345678",
    "database": "circuitor",
    "pool_size": 5,  # Número máximo de conexiones en la piscina
}

# Crear la piscina de conexiones
cnxpool = mysql.connector.pooling.MySQLConnectionPool(**dbconfig)

while True:
    try:
        # Obtener una conexión de la piscina
        cnx = cnxpool.get_connection()

        # Crear un cursor para ejecutar las consultas
        cursor = cnx.cursor(prepared=True)

        # Consulta para obtener el número de registros con pot_15 NULL
        query0 = "SELECT COUNT(*) FROM mt WHERE pot_15 IS NULL"

        # Ejecutar la consulta para obtener el número de registros
        cursor.execute(query0)
        num_null_records = cursor.fetchone()[0]

        # Imprimir el número de registros con pot_15 NULL
        print(f"Número de registros con pot_15 NULL: {num_null_records}")

        print()

        # Consulta SELECT para obtener registros con pot_15 NULL
        query = "SELECT * FROM mt WHERE pot_15 IS NULL ORDER BY `mt`.`unixtime` DESC LIMIT 1"

        # Definir el número de iteraciones
        n = 10

        # Ejecutar el bucle n veces
        for _ in range(n):
            # Ejecutar la consulta preparada para obtener el resultado
            cursor.execute(query)
            row = cursor.fetchone()

            # Comprobar si se obtuvo un resultado
            if row is not None:
                # Acceder a los valores de cada columna
                id = row[0]
                unixtime = row[2]
                energia = row[6]

                # Consulta SELECT con condición adicional
                query2 = "SELECT * FROM mt WHERE unixtime BETWEEN %s AND %s LIMIT 1"

                # Ejecutar la consulta preparada con los parámetros
                cursor.execute(query2, (unixtime - 900, unixtime))
                row2 = cursor.fetchone()

                # Comprobar si se obtuvo un resultado
                if row2 is not None:
                    # Acceder a los valores de cada columna
                    unixtime2 = row2[2]
                    energia2 = row2[6]

                    # Calcular los valores necesarios
                    delta_energia = energia - energia2
                    delta_unixtime_s = unixtime - unixtime2
                    delta_unixtime_h = delta_unixtime_s / 3600
                    potencia = round(delta_energia / (delta_unixtime_h * 1000), 1)

                    # Actualizar los valores en la base de datos
                    query3 = "UPDATE `mt` SET `pot_15` = %s WHERE `mt`.`id` = %s"
                    cursor.execute(query3, (potencia, id))
                    query4 = "UPDATE `mt` SET `pot_15` = {potencia} WHERE `mt`.`id` = {id}"
                    query4 = query4.format(potencia=potencia, id=id)
                    # Imprimir los valores o hacer algo con ellos
                    print(query4)

        # Confirmar los cambios en la base de datos
        cnx.commit()

    except Exception as e:
        print(f"Ocurrió un error: {str(e)}")

    finally:
        # Cerrar el cursor y la conexión
        cursor.close()
        cnx.close()

input("Saliendo, presione ENTER")
