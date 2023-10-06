#autorun_V1.py
import json
import os
import datetime
import time
import csv
import requests
from io import StringIO

from data import  data_validator
from db import check_db_table, create_db, create_table
import server_communication





while True:
    # Obtener la ubicación del script auto_run.py
    script_directory = os.path.dirname(os.path.abspath(__file__))
    config_directory = os.path.abspath(os.path.join(script_directory, '../config'))  # Retrocede dos niveles para acceder a 'config'
    config_file_path = os.path.join(config_directory, 'config.json')
    print("Config File Path:", config_file_path)

    # Cargar la configuración desde config.json
    try:
        with open(config_file_path, 'r') as config_file:
            config_data = json.load(config_file)
            end_time_str = config_data.get('end_time', '')
            
            if end_time_str:
                end_time = datetime.datetime.fromisoformat(end_time_str)
                print("end_time: ",end_time)
                current_time = datetime.datetime.now()
                print("current_time: ",current_time)

                # Calcular la diferencia en minutos
                time_difference = (current_time - end_time).total_seconds() / 60
                print("Time Difference (minutes):", time_difference)

                if time_difference > 5:
                    print("Ejecutando main.py...")
                    contador = 0

                    start_time = datetime.datetime.now()
                    print(f"Inicio del proceso: {start_time}")
                    
                    # Obtener la ubicación del directorio actual (donde se encuentra main.py)
                    script_directory = os.path.dirname(os.path.abspath(__file__))
                    
                    # Navegar desde el directorio del script hasta el directorio de configuración
                    config_directory = os.path.join(script_directory, '../config')
                    config_file_path = os.path.join(config_directory, 'config.json')

                    # Cargar la URL predeterminada desde el archivo de configuración
                    try:
                        with open(config_file_path, 'r') as config_file:
                            config_data = json.load(config_file)
                            CSV_file = config_data.get('CSV_file', '')
                    except FileNotFoundError:
                        CSV_file = "URL predeterminada no encontrada"

                    # Llamar a la función para verificar la base de datos y la tabla
                    check_db_table.check_database_table_exists(config_file_path)
                    data = []
                    try:
                        response = requests.get(file_url)
                        response.raise_for_status()

                        if response.status_code == 200:
                            csv_data = StringIO(response.text)
                            reader = csv.DictReader(csv_data)
                            for row in reader:
                                data.append(row)
                        else:
                            print(f"Error al descargar el archivo CSV - Código: {response.status_code}")
                    except requests.exceptions.RequestException as e:
                        print(f"Error de conexión al descargar el archivo CSV: {str(e)}")
                    except Exception as e:
                        print(f"Error al procesar el archivo CSV: {str(e)}")

                    data = data_reader.read_csv_data(CSV_file)  # Descargar el archivo CSV desde la URL

                    if not data:
                        print("No se pudieron leer los datos del archivo.")
                        input("enter")
                        

                    total = len(data)  # Obtiene el número total de filas en el archivo CSV

                    for row in data:
                        if data_validator.validate_row(row):
                            payload = {
                                'unixtime': row['timestamp'],
                                'potencia_r': row['R:p'],
                                'potencia_s': row['S:p'],
                                'potencia_t': row['T:p'],
                                'v_r': row['R:v'],
                                'v_s': row['S:v'],
                                'v_t': row['T:v']
                            }
                            try:
                                response = server_communication.send_data_to_server(payload)
                                contador = contador + 1
                                contador_str = str(contador).zfill(4)
                                print(f"{contador_str} de {total} - Respuesta del servidor: {response}")
                            except Exception as e:
                                print("Error al enviar datos al servidor:", e)

                    end_time = datetime.datetime.now()
                    print(f"Fin del proceso: {end_time}")

                    duration = end_time - start_time
                    print(f"Duración del proceso: {duration}")

                    # Convertir end_time a cadena de texto y almacenar en config.json
                    config_data['end_time'] = end_time.isoformat()
                    with open(config_file_path, 'w') as config_file:
                        json.dump(config_data, config_file, indent=4)

  

    except (FileNotFoundError, json.JSONDecodeError):
        pass  # Manejo de errores si config.json no existe o no es válido

    # Cuenta regresiva de 60 segundos antes de volver a verificar
    for i in range(60, 0, -1):
        print(f"Próxima verificación en {i} segundos...", end='\r')
        time.sleep(1)

