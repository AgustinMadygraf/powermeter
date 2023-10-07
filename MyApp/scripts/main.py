from data import data_reader, data_validator
#from db import check_db_table
import server_communication
import datetime
import json
import sys

def main():
    contador = 0

    start_time = datetime.datetime.now()
    print(f"Inicio del proceso: {start_time}")
    
    # Ruta completa al archivo config.json
    config_file_path = "C:/config_python/config.json"

    # Llamar a la función para verificar la base de datos y la tabla
    print("config_file_path: ", config_file_path)
    #check_db_table.check_database_table_exists()
    
    try:
        with open(config_file_path, 'r') as config_file:
            config_data = json.load(config_file)
            CSV_file = config_data.get('CSV_file', '')
    except FileNotFoundError:
        CSV_file = "URL predeterminada no encontrada"

    data = data_reader.read_csv_data(CSV_file)  # Descargar el archivo CSV desde la URL

    if not data:
        print("No se pudieron leer los datos del archivo.")
        input("enter")
        return

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
    #input("presione una tecla para salir")

    # Convertir end_time a cadena de texto y almacenar en config.json
    config_data['end_time'] = end_time.isoformat()
    with open(config_file_path, 'w') as config_file:
        json.dump(config_data, config_file, indent=4)

if __name__ == "__main__":
    try:
        main()
    except Exception as e:
        print("Error en la ejecución de main.py:", e)
        sys.exit(1)
