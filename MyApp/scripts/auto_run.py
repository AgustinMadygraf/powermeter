#auto_run.py
from config import configjson
import os
import datetime
import time
import main

while True:
    # Ruta completa al archivo config.json
    config_data = configjson.load_config()

    if config_data:
        end_time_str = config_data.get('end_time', '')

        if end_time_str:
            end_time = datetime.datetime.fromisoformat(end_time_str)
            current_time = datetime.datetime.now()

            # Formatear las fechas con solo un dígito después de la coma
            end_time_str = end_time.strftime("%Y-%m-%d %H:%M:%S.%f")[:-3]
            current_time_str = current_time.strftime("%Y-%m-%d %H:%M:%S.%f")[:-3]

            print("end_time: ", end_time_str)
            print("current_time: ", current_time_str)

            # Calcular la diferencia en segundos
            time_difference = (current_time - end_time).total_seconds()
            print("Diferencia de tiempos (segundos):", time_difference)

            if time_difference > 2:
                print("Ejecutando main.py...")
                # Ejecutar main.py
                main.main()

    # Cuenta regresiva de 60 segundos antes de volver a verificar
    for i in range(180, 0, -1):
        print(f"Próxima verificación en {i} segundos...", end='\r')
        time.sleep(1)
