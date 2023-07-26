import os
import requests
import time

url = 'http://panel.powermeter.com.ar/descargar/directa/inst/f2efe1a1-f021-4288-8a22-be86df14308c/'
filename = 'datos.csv'
save_location = 'C:/AppServ/www/mediciones/BT_A/'
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

