# mysql_connector.py
import mysql.connector

def create_database(host, user, password, db):
    try:
        connection = mysql.connector.connect(
            host=host,
            user=user,
            password=password,
        )

        cursor = connection.cursor()
        cursor.execute(f"CREATE DATABASE {db}")
        print(f"La base de datos '{db}' se ha creado correctamente.")
    except mysql.connector.Error as error:
        print(f"Error al crear la base de datos: {error}")
    finally:
        if connection.is_connected():
            cursor.close()
            connection.close()
