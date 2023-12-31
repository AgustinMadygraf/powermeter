#check_db_table.py
import mysql.connector
import json
import os
#from db import create_db, create_table  # Asegúrate de importar create_db y create_table desde la ubicación correcta

def check_database_table_exists(config_path):
    connection = None  # Inicializar la variable de conexión

    try:
        with open(config_path, 'r') as config_file:
            config_data = json.load(config_file)
            host = config_data.get('host', '')
            user = config_data.get('user', '')
            password = config_data.get('password', '')
            db = config_data.get('db', '')
            table = config_data.get('table', '')
            sql_file = config_data.get('sql_file', '')

        # Conectar a MySQL
        connection = mysql.connector.connect(
            host=host,
            user=user,
            password=password
        )

        cursor = connection.cursor()

        # Verificar si la base de datos existe
        cursor.execute("SHOW DATABASES")
        databases = [database[0] for database in cursor]
        if db in databases:
            print(f"La base de datos '{db}' existe.")
        else:
            print(f"La base de datos '{db}' no existe.")
            create_db.create_database(host, user, password, db)

        # Verificar si la tabla existe
        cursor.execute(f"SHOW TABLES IN {db}")
        tables = [table[0] for table in cursor]
        if table in tables:
            print(f"La tabla '{table}' existe en la base de datos '{db}'.")
        else:
            print(f"La tabla '{table}' no existe en la base de datos '{db}'.")
            create_table.create_table_from_sql(host, user, password, db, table, sql_file)

    except mysql.connector.Error as error:
        print(f"Error al conectar a MySQL: {error}")

    finally:
        if connection:
            connection.close()  # Cerrar la conexión si está abierta

if __name__ == "__main__":
    script_directory = os.path.dirname(os.path.abspath(__file__))
    config_path = "C:/config_python/config.json"

    check_database_table_exists(config_path)
