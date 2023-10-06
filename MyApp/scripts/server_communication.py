#server_communication.py
import requests

# URL del servidor donde se enviarán los datos
server_url = 'http://localhost/powermeter/BT_A1/procesar_powermeter.php'

def send_data_to_server(data):
    #print("Inicio de la función send_data_to_server")
    try:
        response = requests.get(server_url, params=data)
        response.raise_for_status()  # Esto generará una excepción si hay un error en la respuesta del servidor

        if response.status_code == 200:
            #print("Fin de la función send_data_to_server (éxito)")
            return response.text
        else:
            print(f"Fin de la función send_data_to_server (error del servidor - Código: {response.status_code})")
            return f"Error del servidor - Código: {response.status_code}"
    except requests.exceptions.RequestException as e:
        print(f"Fin de la función send_data_to_server (error de conexión: {str(e)})")
        return f"Error de conexión: {str(e)}"
    except requests.exceptions.HTTPError as e:
        print(f"Fin de la función send_data_to_server (error HTTP: {str(e)})")
        return f"Error HTTP: {str(e)}"