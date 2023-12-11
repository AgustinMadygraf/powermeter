#ChatBot_Telegram.py problema en la línea 175
import os
import openai
import json
import time
import requests
import random
import sys
import telegram
import asyncio
import TelegramChatArchiver

async def send(full_reply_content):
    token_telegram = os.getenv('telegram_token')
    bot = telegram.Bot(token_telegram)
    async with bot:
        await bot.send_message(text=full_reply_content, chat_id=593052206)
def limpiar_pantalla():
    os.system('cls' if os.name == 'nt' else 'clear')
def obtener_api_key():
    clave_api = os.getenv('OPENAI_API_KEY')
    if clave_api:
        print("Clave API encontrada en las variables de entorno.")
        return clave_api
    else:
        print("No se encontró la clave API en las variables de entorno. presione enter para salir")
        input()
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
async def procesar_respuesta(chat_history, user_info, user_id):
    # Definir las variables de tiempo de espera y reintentos
    tiempo_espera_base = 1  # tiempo de espera base en segundos
    tiempo_espera_maximo = 60  # tiempo de espera máximo en segundos
    max_reintentos = 5

    user_id_str = str(user_id)

    # Extraer solo los mensajes del usuario especificado y preparar para OpenAI
    user_messages = chat_history.get(user_id_str, [])
    openai_messages = [{"role": msg["role"], "content": msg["content"]} for msg in user_messages]

    for intento in range(max_reintentos):
        try:
            response_iterator = openai.ChatCompletion.create(
                model="gpt-4",
                messages=openai_messages,  # Usa solo los campos necesarios para OpenAI
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
            chat_history[user_id_str].append({"role": "assistant", "content": full_reply_content})

            print(f"GPT: {full_reply_content}")
            await send(full_reply_content)
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
        # Modificar cada mensaje para agregar 'unixtime' y 'update_id'
        for chat_id, messages in chat_history.items():
            for message in messages:
                if 'unixtime' not in message:
                    message['unixtime'] = int(time.time())
                if 'update_id' not in message:
                    message['update_id'] = 0

        data = {
            "chat_histories": chat_history,
            "user_info": user_info
        }
        
        with open(chat_history_path, 'w') as file:
            json.dump(data, file, indent=4)

    except Exception as e:
        print(f"No se pudo guardar el historial del chat. Error: {e}")
async def main():
    limpiar_pantalla()
    print("Versión de Python:")
    print(sys.version)
    print("")
    print("Inicializando...")
    chat_history_path = "context_window_telegram.json"
    print(f"El archivo seleccionado para trabajar es: {chat_history_path}")
    clave_api = obtener_api_key()
    if clave_api is None:
        print("No se proporcionó una clave API válida.")
        exit()
    openai.api_key = obtener_api_key()
    user_id_str = str(593052206)
    while True:
        try:
            chat_history, user_info, ultimo_rol = cargar_chat_history(chat_history_path)
            if ultimo_rol:
                print(f"El último mensaje en la conversación con el usuario 593052206 fue de un '{ultimo_rol}'.")

            if ultimo_rol == "user":                
                await procesar_respuesta(chat_history, user_info, user_id_str)
            else:
                print("Esperando  consulta desde Telegram")
                time.sleep(1)
                print("3")
                time.sleep(1)
                print("2")
                time.sleep(1)
                print("1")
                time.sleep(1)
                print("0")
                await TelegramChatArchiver.main()    #acá está el problema

        except openai.error.AuthenticationError:
            print("\nError de autenticación. Presione enter para salir.")
            input()
            break
chat_history_path = "context_window_telegram.json"
if __name__ == '__main__':
    asyncio.run(main())