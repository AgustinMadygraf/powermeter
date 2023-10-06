#create_db.py
import mysql.connector

def create_database(host, user, password, db):
    try:
        connection = mysql.connector.connect(
            host=host,
            user=user,
            password=password,
        )

        cursor = connection.cursor()

        # Verificar si la base de datos existe
        cursor.execute("SHOW DATABASES")
        databases = [database[0] for database in cursor]
        if db in databases:
            print(f"La base de datos '{db}' existe.")
        else:
            print(f"La base de datos '{db}' no existe.")
            # Código para crear la base de datos

        cursor.close()
        connection.close()
    except mysql.connector.Error as error:
        print(f"Error al conectar a MySQL: {error}")