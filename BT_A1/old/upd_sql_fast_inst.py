import csv
import requests
import time

print('Enviar datos')
print("")
time.sleep(1)
# Definir la URL del archivo procesar_powermeter.php
url = 'http://localhost/mediciones/BT_A1/procesar_powermeter.php'

# Leer el archivo CSV y ordenar por unixtime en orden descendente
with open('datos_inst.csv', newline='') as csvfile:
    reader = csv.DictReader(csvfile)
    sorted_rows = sorted(reader, key=lambda row: int(row['timestamp']), reverse=True)

# Seleccionar las 12 primeras filas con el valor más alto de unixtime
rows_to_send = sorted_rows[:12]

# Iterar sobre las filas seleccionadas
for row in rows_to_send:
    # Obtener los valores de fecha, timestamp y potencias
    fecha = row['fecha']
    timestamp = row['timestamp']
    r_v = row['R:v']
    r_i = row['R:i']
    r_p = row['R:p']
    r_q = row['R:q']
    s_v = row['S:v']
    s_i = row['S:i']
    s_p = row['S:p']
    s_q = row['S:q']
    t_v = row['T:v']
    t_i = row['T:i']
    t_p = row['T:p']
    t_q = row['T:q']

    # Enviar los datos al archivo procesar_powermeter.php
    payload = {'unixtime': timestamp, 'potencia_s': s_p, 'potencia_r': r_p, 'potencia_t': t_p, 'v_s': s_v, 'v_r': r_v, 'v_t': t_v}
    r = requests.get(url, params=payload)
    print(r.text)  # Mostrar la respuesta del servidor
    time.sleep(1)
