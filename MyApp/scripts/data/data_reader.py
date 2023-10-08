import csv
import requests
from io import StringIO
import os

def read_csv_data(file_url_path):
    data = []
    is_url = file_url_path.startswith('http://') or file_url_path.startswith('https://')

    try:
        if is_url:
            # Si la entrada es una URL, descarga los datos desde la URL
            response = requests.get(file_url_path)
            response.raise_for_status()
            
            if response.status_code == 200:
                csv_data = StringIO(response.text)
                reader = csv.DictReader(csv_data)
                for row in reader:
                    data.append(row)
            else:
                print(f"Error al descargar el archivo CSV - Código: {response.status_code}")
                return []
        else:
            # Si la entrada no es una URL, se asume que es una ruta de archivo local
            if os.path.isfile(file_url_path):
                with open(file_url_path, 'r', newline='') as csvfile:
                    reader = csv.DictReader(csvfile)
                    for row in reader:
                        data.append(row)
            else:
                print(f"El archivo CSV no existe en la ruta: {file_url_path}")
                return []
            
        return data
    except requests.exceptions.RequestException as e:
        print(f"Error de conexión al descargar el archivo CSV: {str(e)}")
        return []
    except Exception as e:
        print(f"Error al procesar el archivo CSV: {str(e)}")
        return []
