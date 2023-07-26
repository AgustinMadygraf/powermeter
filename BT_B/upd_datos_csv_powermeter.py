import os
import requests
import time

url = 'http://panel.powermeter.com.ar/descargar/directa/inst/7c275d46-0122-4c05-81f8-e973ecbe26d7/'
filename = 'datos.csv'
save_location = 'C:/AppServ/www/mediciones/BT_B/'
nombre_archivo = 'datos.csv'
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

