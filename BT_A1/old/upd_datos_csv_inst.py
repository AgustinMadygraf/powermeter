import os
import requests
import time

url = 'http://panel.powermeter.com.ar/descargar/directa/inst/56ae1c10-059b-4764-abec-f7bdc5e56603/'
filename = 'datos_inst.csv'
save_location = 'C:/AppServ/www/mediciones/BT_A1/'
nombre_archivo = 'datos_inst.csv'
print()
print(f"url: {url}")
print()
time.sleep(1)
print(f"filename: {filename}")
print()
time.sleep(1)
print(f"save_location: {save_location}")
print()
# Realizar la petición GET
respuesta = requests.get(url)
# Guardar el archivo descargado
with open(nombre_archivo, 'wb') as archivo:
    archivo.write(respuesta.content)
print("finalizado")
#input("Presione cualquier tecla para salir")

