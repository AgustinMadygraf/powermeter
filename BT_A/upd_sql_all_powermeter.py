import csv
import requests
import time


# Definir la URL del archivo procesar_powermeter.php
url = 'http://localhost/mediciones/BT_A/procesar_powermeter.php'
# Abrir el archivo CSV y leer los datos
with open('datos.csv', newline='') as csvfile:
    # Crear un lector CSV
    reader = csv.DictReader(csvfile)
    # Iterar sobre cada fila del archivo
    for row in reader:
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
        f1 = float(s_p)
        if int(f1) >= 0:
            payload = {'unixtime': timestamp, 'potencia_s': s_p, 'potencia_r': r_p, 'potencia_t': t_p, 'v_s': s_v, 'v_r': r_v, 'v_t': t_v}
            r = requests.get(url, params=payload)
            print(r.text)  # Mostrar la respuesta del servidor
        else:
            print("El valor de potencia_s es menor que cero")
            print("")

            

print("")
print("finalizado")
print("")
