print("Inicializando...")

import os
import openai
import mysql.connector
import json

# Limpiar la pantalla de la terminal antes de comenzar (funciona en Windows).
os.system('cls' if os.name == 'nt' else 'clear')


def read_db_config(file_path):
    with open(file_path, 'r') as file:
        db_config = json.load(file)
    return db_config

# Llamar a la función y pasar la ruta del archivo de configuración
db_config = read_db_config('db_config.json')


# Función para obtener la API key de un archivo.
def get_api_key(file_path):
    print(f"Leyendo API key desde {file_path}...")
    with open(file_path, 'r') as file:
        return file.readline().strip()

api_key_path = "path_al_archivo_con_tu_clave.txt"
openai.api_key = get_api_key(api_key_path)

# Configuración de la conexión a la base de datos MySQL.
print("Configurando conexión a la base de datos...")

# Conectar a la base de datos MySQL.
print("Conectando a la base de datos...")
db_connection = mysql.connector.connect(**db_config)
cursor = db_connection.cursor()

# Función para insertar una nueva declaración en la base de datos.
def insert_response(question, answer):
    print(f"Insertando respuesta en la base de datos para la pregunta: '{question}'")
    try:
        cursor.execute("""
            INSERT INTO statement (text, search_text, conversation, created_at, in_response_to, search_in_response_to, persona)
            VALUES (%s, '', 'training', NOW(), %s, '', '')
        """, (answer[:255], question))  # Truncate the answer to 255 characters.
        db_connection.commit()
        print("Inserción exitosa.")
    except mysql.connector.Error as err:
        print("Error en la base de datos:", err)
        db_connection.rollback()

def generate_and_insert_responses(questions):
    for question in questions:
        print(f"Generando respuesta para: '{question}'")
        try:
            # Llamamos a la API de OpenAI para obtener la respuesta a la pregunta utilizando el endpoint adecuado.
            response = openai.ChatCompletion.create(
                model="gpt-3.5-turbo",
                messages=[{"role": "user", "content": question}],
                max_tokens=150  # Establece un límite aproximado de tokens para controlar el tamaño de la respuesta.
            )
            answer = response['choices'][0]['message']['content']
            # Truncate the answer if it is longer than 255 characters before inserting.
            if len(answer) > 255:
                print(f"Truncando respuesta que excede 255 caracteres: {answer}")
                answer = answer[:252] + '...'  # Optional: add ellipsis to indicate truncation.
            insert_response(question, answer)
        except openai.error.OpenAIError as e:
            print(f"Error with OpenAI API for question '{question}': {e}")
        except Exception as e:
            print(f"An unexpected error occurred for question '{question}': {e}")

# Lista de preguntas predefinidas para el chatbot.
print("Preparando preguntas para el aprendizaje...")
questions_to_learn = [
    "What is the capital of France?",
    "How do you make an omelette?",
    # Agrega más preguntas según sea necesario.
]

# Genera y guarda las respuestas en la base de datos MySQL.
generate_and_insert_responses(questions_to_learn)

# No olvides cerrar la conexión a la base de datos al final.
print("Cerrando la conexión a la base de datos...")
cursor.close()
db_connection.close()

print("Las respuestas se han guardado en la base de datos.")
