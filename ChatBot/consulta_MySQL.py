#consulta_MySQL.py
import os
import json
import mysql.connector
from prettytable import PrettyTable

def clear_screen():
    os.system('cls' if os.name == 'nt' else 'clear')

def read_db_config(file_path):
    with open(file_path, 'r') as file:
        return json.load(file)

def connect_database(config):
    return mysql.connector.connect(**config)

def get_table_description(cursor, table_name):
    cursor.execute(f"DESCRIBE {table_name};")
    return cursor.fetchall()

def execute_query(cursor, query):
    cursor.execute(query)
    return cursor.fetchall()

def print_table_from_description(column_descriptions, data):
    table = PrettyTable()
    table.field_names = ["Field", "Value"]
    for desc, value in zip(column_descriptions, data[0]):
        table.add_row([desc[0], value])
    return table

def main(db_config_path='db_config.json'):
    prompt = ""  # Inicializamos 'prompt' como una cadena vacía
    db_config = read_db_config(db_config_path)
    try:
        cnx = connect_database(db_config)
        cursor = cnx.cursor()
        column_descriptions = get_table_description(cursor, 'statement')
        query = "SELECT * FROM `statement` WHERE `persona` = '' ORDER BY `statement`.`created_at` ASC LIMIT 1"
        results = execute_query(cursor, query)
        if results:
            prompt = print_table_from_description(column_descriptions, results)
            return prompt.get_string()  # Suponiendo que quieres la tabla completa como 'prompt'
        else:
            print("No hay registros para mostrar.")
    except mysql.connector.Error as err:
        print(f"Error en la base de datos: {err}")
    except Exception as e:
        print(f"Un error inesperado ocurrió: {e}")
    finally:
        if cnx.is_connected():
            cursor.close()
            cnx.close()
    return prompt



if __name__ == "__main__":
    prompt = main()
    print(prompt)