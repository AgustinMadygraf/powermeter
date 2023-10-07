#auto_run.py
from config import configjson
import os
import datetime
import time
import main

while True:
    # Obtener la ubicación del script auto_run.py
    script_directory = os.path.dirname(os.path.abspath(__file__))
    print("script_directory: ",script_directory)
    config_data = configjson.load_config(script_directory)

    if config_data:
        end_time_str = config_data.get('end_time', '')
        
        if end_time_str:
            end_time = datetime.datetime.fromisoformat(end_time_str)
            print("end_time: ", end_time)
            current_time = datetime.datetime.now()
            print("current_time: ", current_time)

            # Calcular la diferencia en minutos
            time_difference = (current_time - end_time).total_seconds() / 60
            print("Time Difference (minutes):", time_difference)

            if time_difference > 5:
                print("Ejecutando main.py...")
                # Ejecutar main.py
                main.main()

    # Cuenta regresiva de 60 segundos antes de volver a verificar
    for i in range(60, 0, -1):
        print(f"Próxima verificación en {i} segundos...", end='\r')
        time.sleep(1)
