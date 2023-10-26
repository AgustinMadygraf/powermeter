import sys
import time

for i in range(10):
    sys.stdout.write(f"\rProgreso: {i * 10}%")  # Utiliza \r para volver al principio de la línea
    sys.stdout.flush()  # Limpia el búfer de salida para mostrar la información inmediatamente
    time.sleep(1)  # Espera un segundo (esto puede ser tu lógica de actualización)
