import csv
import mysql.connector
import os
from datetime import datetime

# Obtener datos de conexión de las variables de entorno
host = os.getenv('DB_HOST', 'localhost')
user = os.getenv('DB_USER', 'root')
password = os.getenv('DB_PASS', '12345678')

# Conexión a la base de datos
db = mysql.connector.connect(
    host=host, 
    user=user, 
    password=password, 
    database="produccion"
)
cursor = db.cursor()

# Función para convertir la fecha al formato de MySQL
def convertir_fecha(fecha):
    try:
        return datetime.strptime(fecha, '%d/%m/%Y').strftime('%Y-%m-%d')
    except ValueError:
        # Devolver NULL si la fecha está vacía o es inválida
        return None

# Leer el archivo CSV y subir los datos
with open('C:\\AppServ\\www\\powermeter\\produccion\\CSV\\offset_produccion.csv', 'r', encoding='utf-8') as file:
    reader = csv.reader(file)
    next(reader)  # Saltar la cabecera
    for row in reader:
        row[3] = convertir_fecha(row[3])
        cursor.execute("INSERT INTO grafica_offset (OP, Tiros_Generales, Producto, Fecha_Despacho) VALUES (%s, %s, %s, %s)", row)
    db.commit()
# Leer el archivo CSV y subir los datos
with open('C:\\AppServ\\www\\powermeter\\produccion\\CSV\\offset_produccion.csv', 'r', encoding='utf-8') as file:
    reader = csv.reader(file)
    next(reader)  # Saltar la cabecera
    for row in reader:
        row[3] = convertir_fecha(row[3])
        cursor.execute("INSERT INTO grafica_offset (OP, Tiros_Generales, Producto, Fecha_Despacho) VALUES (%s, %s, %s, %s)", row)
    db.commit()


cursor.close()
db.close()
