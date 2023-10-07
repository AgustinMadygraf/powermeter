#check_db_table.py
import mysql.connector
import json
import os
import create_db, create_table

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
            print("host: ",host)
            print("user: ",user)
            print("password: ",password)

        # Conectar a MySQL
        connection = mysql.connector.connect(
            host=host,
            user=user,
            password=password
        )
        print(connection)

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
            create_table.create_table_from_sql(host, user, password, db, table, "inst_bt_a1.sql")

    except mysql.connector.Error as error:
        print(f"Error al conectar a MySQL: {error}")

    finally:
        if connection:
            connection.close()  # Cerrar la conexión si está abierta

if __name__ == "__main__":
    script_directory = os.path.dirname(os.path.abspath(__file__))
    config_path = os.path.join(script_directory, '..', '..', 'config', 'config.json')


    check_database_table_exists(config_path)

