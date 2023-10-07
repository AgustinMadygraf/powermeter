#create_table.py
import mysql.connector
import os
import json


def create_table_from_sql(host, user, password, db, table, sql_file):
    print("iniciando módulo: 'create_table.py'")
    print("host: ",host)
    print("user: ",user)
    print("password: ",password)
    print("db: ",db)
    print("table: ",table)
    print("sql_file: ",sql_file)

    try:
        # Conectarse a MySQL
        connection = mysql.connector.connect(
            host=host,
            user=user,
            password=password,
            database=db
        )

        cursor = connection.cursor()

        # Obtener la ruta completa al archivo SQL
        script_directory = os.path.dirname(os.path.abspath(__file__))
        sql_file_path = os.path.join(script_directory, sql_file)

        print("____")
        print("script_directory: ",script_directory)      
        print("sql_file_path: ",sql_file_path)
        # Leer el contenido del archivo SQL con codificación UTF-8
        with open(sql_file_path, 'r', encoding='utf-8') as sql_script:
            sql_query = sql_script.read()
        # Ejecutar el script SQL para crear la tabla
        cursor.execute(sql_query)

        print(f"La tabla '{table}' se ha creado en la base de datos '{db}'.")

    except mysql.connector.Error as error:
        print(f"Error al crear la tabla: {error}")

    finally:
        if connection.is_connected():
            cursor.close()
            connection.close()

if __name__ == "__main__":
    script_directory = os.path.dirname(os.path.abspath(__file__))
    config_path = os.path.join(script_directory, '..', '..', 'config', 'config.json')
    


    # Cargar la configuración desde config.json
    try:
        with open(config_path, 'r') as config_file:
            config_data = json.load(config_file)
            host = config_data.get('host', '')
            user = config_data.get('user', '')
            password = config_data.get('password', '')
            db = config_data.get('db', '')
            table = config_data.get('table', '')
            sql_file = config_data.get('sql_file', '')
            create_table_from_sql(host, user, password, db, table,sql_file)
    except FileNotFoundError:
        print("El archivo de configuración no existe en la ubicación especificada.")
