#data_reader.py
import csv
import requests
from io import StringIO

def read_csv_data(file_url):
    data = []
    try:
        response = requests.get(file_url)
        response.raise_for_status()

        if response.status_code == 200:
            csv_data = StringIO(response.text)
            reader = csv.DictReader(csv_data)
            for row in reader:
                data.append(row)
            return data
        else:
            print(f"Error al descargar el archivo CSV - Código: {response.status_code}")
            return []
    except requests.exceptions.RequestException as e:
        print(f"Error de conexión al descargar el archivo CSV: {str(e)}")
        return []
    except Exception as e:
        print(f"Error al procesar el archivo CSV: {str(e)}")
        return []
    
    