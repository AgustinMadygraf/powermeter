import mysql.connector
from mysql.connector import Error
from datetime import datetime, timedelta

# Función para calcular el promedio de potencia_III para cada día de la semana
def calcular_promedio_por_dia(data):
    promedios_por_dia = {hora: 0 for hora in range(24)}
    contador_registros_por_hora = {hora: 0 for hora in range(24)}

    for registro in data:
        hora = registro['datetime'].hour
        promedios_por_dia[hora] += registro['potencia_III']
        contador_registros_por_hora[hora] += 1

    for hora in promedios_por_dia:
        if contador_registros_por_hora[hora] > 0:
            promedios_por_dia[hora] /= contador_registros_por_hora[hora]
            promedios_por_dia[hora] = round(promedios_por_dia[hora], 1)

    return promedios_por_dia

try:
    # Establecer la conexión a la base de datos
    connection = mysql.connector.connect(
        host='localhost',
        user='root',
        password='12345678',
        database='powermeter'
    )

    if connection.is_connected():
        print('Conexión exitosa a la base de datos')

        # Realizar las consultas a la tabla "inst_bt_a1" para obtener los datos de cada día de la semana
        cursor = connection.cursor(dictionary=True)
        promedios_por_dia = {}

        for dia in range(1, 8):
            query = f"SELECT `id`, `datetime`, `potencia_III`, `dia` FROM `inst_bt_a1` WHERE `dia` = {dia}"
            cursor.execute(query)
            data = cursor.fetchall()

            # Calcular el promedio de potencia_III para el día actual
            promedios_por_dia[dia] = calcular_promedio_por_dia(data)

        cursor.close()

        # Guardar los resultados en la tabla "promedio"
        cursor = connection.cursor()
        hora_actual = datetime.strptime('00:00:00', '%H:%M:%S').time()
        intervalo = timedelta(minutes=5)

        for dia, promedios in promedios_por_dia.items():
            for _ in range(288):  # 24 horas x 60 minutos / 5 minutos por intervalo = 288
                promedio = promedios.get(hora_actual.hour, 0)  # Verificar si la clave existe en el diccionario
                hora_actual_str = hora_actual.strftime('%H:%M:%S')  # Convertir a formato de hora como cadena
                insert_query = "INSERT INTO `promedio` (`hora`, `pot_prom`, `dia`) VALUES (%s, %s, %s)"
                values = (hora_actual_str, promedio, dia)
                cursor.execute(insert_query, values)
                hora_actual = (datetime.combine(datetime.today(), hora_actual) + intervalo).time()

        connection.commit()
        cursor.close()

        print('Promedios históricos calculados y guardados exitosamente')

except Error as e:
    print('Error en la conexión o consulta a la base de datos:', e)

finally:
    if connection.is_connected():
        connection.close()
        print('Conexión cerrada')
