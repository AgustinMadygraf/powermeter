import csv
import requests

# Definir la URL del archivo procesar_powermeter.php
url = 'http://localhost/mediciones/BT_A1/procesar_powermeter.php'

# Función para mostrar mensajes de error
def show_error(error_message):
    print(f"Error: {error_message}")

# Función para validar los datos
def validate_data(data):
    required_columns = ['timestamp', 'R:p', 'S:p', 'T:p', 'R:v', 'S:v', 'T:v']

    for column in required_columns:
        if column not in data:
            return False

        # Verificar que los datos sean numéricos
        try:
            float(data[column])
        except ValueError:
            return False

    return True

# Inicializar el contador
contador = 0

# Abrir el archivo CSV y leer los datos
with open('datos_inst.csv', newline='') as csvfile:
    # Crear un lector CSV
    reader = csv.DictReader(csvfile)
    # Ordenar los datos por la columna 'unixtime' de mayor a menor
    sorted_rows = sorted(reader, key=lambda row: float(row['timestamp']), reverse=True)

    # Iterar sobre cada fila del archivo ordenado
    for row in sorted_rows:
        # Eliminar espacios en blanco alrededor de los nombres de las columnas
        row = {key.strip(): value.strip() for key, value in row.items()}

        # Validar los datos de la fila actual
        if not validate_data(row):
            show_error(f"Datos inválidos en la fila: {row}")
            continue

        # Enviar los datos al archivo procesar_powermeter.php
        payload = {
            'unixtime': row['timestamp'],
            'potencia_r': row['R:p'],
            'potencia_s': row['S:p'],
            'potencia_t': row['T:p'],
            'v_r': row['R:v'],
            'v_s': row['S:v'],
            'v_t': row['T:v']
        }

        r = requests.get(url, params=payload)

        # Mostrar la respuesta del servidor
        if r.status_code == 200:
            print(r.text)
            
            # Verificar si el mensaje es "El registro ya existe en la base de datos"
            if "El registro ya existe en la base de datos" in r.text:
                contador += 1
                if contador == 15:
                    print("15 registros consecutivos que ya están en la base de datos")
                    print("saliendo..")
                    break
        else:
            show_error(f"Error al enviar datos: {r.status_code} - {r.text}")
