#training_chatbot.py
from chatterbot import ChatBot
import mysql.connector
import json
import os
import consulta_MySQL
import ChatBot_OpenAI

def read_db_config(file_path):
    try:
        with open(file_path, 'r') as file:
            return json.load(file)
    except FileNotFoundError:
        print(f"No se pudo encontrar el archivo de configuración: {file_path}")
        exit(1)
    except json.JSONDecodeError:
        print(f"Error al decodificar el archivo de configuración: {file_path}")
        exit(1)

def clear_terminal():
    os.system('cls' if os.name == 'nt' else 'clear')

def main(db_config_path='db_config.json'):
    clear_terminal()
    db_config = read_db_config(db_config_path)
    chatbot = ChatBot(
        'MadyBot',
        storage_adapter='chatterbot.storage.SQLStorageAdapter',
        database_uri=f"mysql+mysqlconnector://{db_config['user']}:{db_config['password']}@{db_config['host']}:3306/{db_config['database']}"
    )
    try:
        conn = mysql.connector.connect(**db_config)
        cursor = conn.cursor()
        cursor.execute("SELECT COUNT(*) FROM `statement`WHERE `persona` = '' ORDER BY `statement`.`created_at` ASC")
        count = cursor.fetchone()[0]
        if count > 1:
            print(f"La base de datos ya tiene {count} registros que no han sido verificados por ChatGPT")
            print("Iniciando entrenamiento")
            consulta_MySQL.main()
            sql_update_query = """
            UPDATE `statement`
            SET `in_response_to` = '[null]'
            WHERE `in_response_to` IS NULL
            """
            cursor.execute(sql_update_query)
            conn.commit()
            print(cursor.rowcount, "registros fueron actualizados.")
        else:
            print(f"La base de datos ya tiene {count} registros, no es necesario entrenar más.")
    except mysql.connector.Error as error:
        print(f"Error al interactuar con la base de datos: {error}")
    finally:
        if conn.is_connected():
            cursor.close()
            conn.close()

if __name__ == "__main__":
    main()
