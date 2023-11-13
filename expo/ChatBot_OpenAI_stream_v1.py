
import os
import openai
import json
import time
import requests
import random

def limpiar_pantalla():
    os.system('cls' if os.name == 'nt' else 'clear')

def obtener_api_key():
    clave_api = os.getenv('OPENAI_API_KEY')
    if clave_api:
        print("Clave API encontrada en las variables de entorno.")
        return clave_api
    else:
        print("No se encontró la clave API en las variables de entorno.")
        print("Escribe 'exit' para salir o escribe el API key manualmente.")
        decision = input()
        if decision.lower() == 'exit':
            return None
        else:
            guardar_api_key_en_variables_de_entorno(decision)
            return decision

def guardar_api_key_en_variables_de_entorno(api_key):
    with open(os.path.expanduser("~/.bashrc"), 'a') as file:
        file.write(f"\nexport OPENAI_API_KEY='{api_key}'")

def cargar_chat_history(file_path):
    try:
        with open(file_path, 'r') as file:
            return json.load(file)
    except FileNotFoundError:
        print(f"No se encontró el archivo: {file_path}. Por favor verifica la ruta.")
        return []
    except json.JSONDecodeError:
        print(f"Error al leer el archivo: {file_path}. Formato de archivo inválido.")
        return []

def iniciar_chat():
    while True:
        prompt = input("Enter a prompt: ")
        if prompt.lower() == "exit":
            break
        else:
            chat_history.append({"role": "user", "content": prompt})
            procesar_respuesta(chat_history)

def procesar_respuesta(chat_history):
    max_reintentos = 5
    tiempo_espera_base = 1  # tiempo de espera base en segundos
    tiempo_espera_maximo = 60  # tiempo de espera máximo en segundos

    for intento in range(max_reintentos):
        try:
            response_iterator = openai.ChatCompletion.create(
                # model="gpt-3.5-turbo",
                model="gpt-4",
                messages=chat_history,
                stream=True,
            )

            collected_messages = []
            for chunk in response_iterator:
                chunk_message = chunk['choices'][0]['delta']
                collected_messages.append(chunk_message)
                full_reply_content = ''.join([m.get('content', '') for m in collected_messages])
                print(full_reply_content)
                time.sleep(0.15)
                limpiar_pantalla()

            chat_history.append({"role": "assistant", "content": full_reply_content})
            print(f"GPT: {full_reply_content}")
            guardar_chat_history(chat_history, chat_history_path)

            break  # Salir del bucle si la solicitud fue exitosa

        except openai.error.RateLimitError:
            print("Se ha alcanzado el límite de tasa de solicitudes. Esperando antes de reintentar...")
            time.sleep(tiempo_espera)
            tiempo_espera *= 2  # Duplicar el tiempo de espera para el próximo reintento
        except openai.error.ServiceUnavailableError:
            print("El servicio de OpenAI no está disponible en este momento. Reintentando...")
            time.sleep(tiempo_espera)
            tiempo_espera *= 2
        except openai.error.InvalidRequestError as e:
            print(f"Error de solicitud inválida: {e}")
            break
        except requests.exceptions.ConnectionError:
            print("Error de conexión. Comprobando la red y reintentando...")
            time.sleep(tiempo_espera)
            tiempo_espera *= 2
        except requests.exceptions.Timeout:
            print("Tiempo de espera agotado para la solicitud. Reintentando...")
            time.sleep(tiempo_espera)
            tiempo_espera *= 2
        except requests.exceptions.HTTPError as e:
            print(f"Error HTTP: {e}")
            break
        except (requests.exceptions.ConnectionError, requests.exceptions.Timeout, requests.exceptions.HTTPError) as e:
            print(f"Error de red o de servidor: {e}. Reintentando...")

            tiempo_espera = min(tiempo_espera_base * (2 ** intento), tiempo_espera_maximo)
            jitter = random.uniform(0, tiempo_espera)
            tiempo_espera_con_jitter = tiempo_espera + jitter

            print(f"Esperando {tiempo_espera_con_jitter:.2f} segundos antes del próximo intento.")
            time.sleep(tiempo_espera_con_jitter)

def imprimir_archivos_json(carpeta):
    archivos = os.listdir(carpeta)
    n = 0
    archivos_json = [archivo for archivo in archivos if archivo.endswith('.json') and archivo.startswith('context_window_')]
    archivos_dict = {}
    for archivo in archivos_json:
        ruta_completa = os.path.join(carpeta, archivo)
        try:
            n += 1
            archivos_dict[str(n)] = archivo  # Asigna el número a cada archivo
            print(f"{n} - {archivo[15:-5]}")
        except Exception as e:
            print(f"No se pudo leer el archivo {archivo}. Error: {e}")
    return archivos_dict

def guardar_chat_history(chat_history, chat_history_path):
    try:
        with open(chat_history_path, 'w') as file:
            json.dump(chat_history, file, indent=4)
    except Exception as e:
        print(f"No se pudo guardar el historial del chat. Error: {e}")



# Inicio del programa
limpiar_pantalla()
print("Inicializando...")

# Uso de la función
carpeta = os.getcwd()  # Obtiene la ubicación actual del script
archivos_dict = imprimir_archivos_json(carpeta)
1
print("Presione el NÚMERO de la opción que desea seleccionar")
while True:
    cgn = input()
    if cgn in archivos_dict:
        chat_history_path = archivos_dict[cgn]
        print(f"Usted seleccionó la opción {cgn}")
        print(f"La opción seleccionada es el archivo: {chat_history_path}")
        break  # Salir del bucle
    else:
        print(f"Selección inválida: {cgn}. Intente de nuevo:")

# Aquí puedes usar chat_history_path para lo que necesites después de la selección
print(f"El archivo seleccionado para trabajar es: {chat_history_path}")

clave_api = obtener_api_key()

if clave_api is None:
    print("No se proporcionó una clave API válida.")
    exit()

while True:
    try:
        chat_history = cargar_chat_history(chat_history_path)
        openai.api_key = clave_api
        procesar_respuesta(chat_history)
        iniciar_chat()  # Solo necesitamos llamar a iniciar_chat
        break
    except openai.error.AuthenticationError:
        print("\nError de autenticación.")
        print("Escribe 'exit' para salir o escribe el API key manualmente.")
        decision = input()
        if decision.lower() == 'exit':
            break  # Sale del bucle y termina el programa
        else:
            guardar_api_key_en_variables_de_entorno(decision)
            clave_api = decision  # Actualiza la clave API y continúa el bucle