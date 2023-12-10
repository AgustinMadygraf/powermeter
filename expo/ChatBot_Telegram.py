#ChatBot_Telegram.py
import os
import openai
import json
import time
import requests
import random
import sys
import telegram


def limpiar_pantalla():
    os.system('cls' if os.name == 'nt' else 'clear')

async def main():
    token_telegram = os.getenv('telegram_token')
    bot = telegram.Bot(token_telegram)

    async with bot:
        historial = await bot.get_updates()

        # Diccionario para almacenar el historial de cada chat
        chat_histories = {}
        user_info = {}

        for update in historial:
            if update.message:
                chat_id = update.message.chat.id
                text = update.message.text

                # Crear una nueva entrada en el diccionario si no existe
                if chat_id not in chat_histories:
                    chat_histories[chat_id] = []

                # Agregar el mensaje al historial del chat
                chat_histories[chat_id].append({
                    "role": "user",
                    "content": text
                })

                # Recolectar la información del usuario
                user = update.message.from_user
                if user.id not in user_info:
                    user_info[user.id] = {
                        "username": user.username or 'Sin username',
                        "first_name": user.first_name,
                        "last_name": user.last_name or '',
                        "id": user.id
                    }

        # Guardar el historial de cada chat y la información del usuario en un archivo JSON
        data_to_save = {
            "user_info": user_info,
            "chat_histories": chat_histories
        }

        with open("context_window_telegram.json", "w", encoding="utf-8") as file:
            json.dump(data_to_save, file, indent=4, ensure_ascii=False)

def obtener_api_key():
    clave_api = os.getenv('OPENAI_API_KEY')
    if clave_api:
        print("Clave API encontrada en las variables de entorno.")
        return clave_api
    else:
        print("No se encontró la clave API en las variables de entorno.")
        print("Escribe 'exit' para salir ")
        if decision.lower() == 'exit':
            return None
def cargar_chat_history(file_path):
    try:
        with open(file_path, 'r') as file:
            data = json.load(file)
            chat_histories = data.get("chat_histories", {})
            user_info = data.get("user_info", {})

            # Identificar el último rol en la conversación del usuario 593052206
            ultimo_rol = None
            chat_usuario_especifico = chat_histories.get("593052206", [])
            if chat_usuario_especifico:
                ultimo_mensaje = chat_usuario_especifico[-1]  # Obtener el último mensaje
                ultimo_rol = ultimo_mensaje.get("role")

            return chat_histories, user_info, ultimo_rol

    except FileNotFoundError:
        print(f"No se encontró el archivo: {file_path}. Por favor verifica la ruta.")
        return {}, {}, None
    except json.JSONDecodeError:
        print(f"Error al leer el archivo: {file_path}. Formato de archivo inválido.")
        return {}, {}, None


def iniciar_chat(chat_history, user_info, user_id):
    # Convertir user_id a string si es necesario (JSON keys son strings)
    user_id_str = str(user_id)

    # Verificar si user_id existe en chat_history, si no, inicializarlo
    if user_id_str not in chat_history:
        chat_history[user_id_str] = []

    while True:
        prompt = input("Enter a prompt: ")
        if prompt.lower() == "exit":
            break
        else:
            # Agregar el mensaje del usuario al historial del chat
            chat_history[user_id_str].append({"role": "user", "content": prompt})
            procesar_respuesta(chat_history, user_info, user_id_str)


def procesar_respuesta(chat_history, user_info, user_id):
    # Definir las variables de tiempo de espera y reintentos
    tiempo_espera_base = 1  # tiempo de espera base en segundos
    tiempo_espera_maximo = 60  # tiempo de espera máximo en segundos
    max_reintentos = 5

    # Extraer solo los mensajes del usuario especificado
    user_messages = chat_history.get(user_id, [])
    
    for intento in range(max_reintentos):
        try:
            response_iterator = openai.ChatCompletion.create(
                model="gpt-4",
                messages=user_messages,  # Esta línea utiliza user_messages
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

            # Agregar la respuesta del asistente al historial del chat
            chat_history[user_id].append({"role": "assistant", "content": full_reply_content})
            print(f"GPT: {full_reply_content}")
            guardar_chat_history(chat_history, user_info, chat_history_path)
            break

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
        except (requests.exceptions.ConnectionError, requests.exceptions.Timeout, requests.exceptions.HTTPError) as e:
            print(f"Error de red o de servidor: {e}. Reintentando...")

            tiempo_espera = min(tiempo_espera_base * (2 ** intento), tiempo_espera_maximo)
            jitter = random.uniform(0, tiempo_espera)
            tiempo_espera_con_jitter = tiempo_espera + jitter

            print(f"Esperando {tiempo_espera_con_jitter:.2f} segundos antes del próximo intento.")
            time.sleep(tiempo_espera_con_jitter)

def guardar_chat_history(chat_history, user_info, chat_history_path):
    try:
        data = {
            "chat_histories": chat_history,
            "user_info": user_info
        }
        with open(chat_history_path, 'w') as file:
            json.dump(data, file, indent=4)
    except Exception as e:
        print(f"No se pudo guardar el historial del chat. Error: {e}")


# Inicio del programa
limpiar_pantalla()
print("Versión de Python:")
print(sys.version)
print("")
print("Inicializando...")

# Uso de la función

chat_history_path = "context_window_telegram.json"

# Aquí puedes usar chat_history_path para lo que necesites después de la selección
print(f"El archivo seleccionado para trabajar es: {chat_history_path}")
time.sleep(4)

clave_api = obtener_api_key()

if clave_api is None:
    print("No se proporcionó una clave API válida.")
    exit()

while True:
    try:
        # Actualiza esta línea para manejar los tres valores devueltos
        chat_history, user_info, ultimo_rol = cargar_chat_history(chat_history_path)

        # Ahora puedes usar `ultimo_rol` para saber si el último mensaje fue de "user" o "assistant"
        if ultimo_rol:
            print(f"El último mensaje en la conversación con el usuario 593052206 fue de un '{ultimo_rol}'.")

        openai.api_key = clave_api
        user_id = 593052206
        iniciar_chat(chat_history, user_info, user_id)
        break

    except openai.error.AuthenticationError:
        print("\nError de autenticación. Escribe 'exit' para salir.")
        decision = input()
        if decision.lower() == 'exit':
            break