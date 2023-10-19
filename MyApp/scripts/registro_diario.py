#registro_diario.py
import pymysql

# Configuración de la base de datos
db_config = {
    'host': 'localhost',
    'user': 'root',
    'password': '12345678',
    'db': 'powermeter'  # Reemplaza 'tu_basededatos' con el nombre de tu base de datos
}

# Conectarse a la base de datos
connection = pymysql.connect(**db_config)
cursor = connection.cursor()

# Nombre del archivo con los datos
archivo = 'C:/AppServ/www/powermeter/MyApp/scripts/tudata.csv'

# Abrir el archivo para lectura
with open(archivo, 'r') as file:
    # Omitir la primera línea, que contiene encabezados
    next(file)
    
    for line in file:
        # Dividir cada línea en campos usando coma como separador
        campos = line.strip().split(',')

        # Extraer valores de campos
        dispositivo, timestamp_utc, timestamp_local, p = campos

        # Dividir el valor p en tres partes iguales
        potencia_total = float(p)
        potencia_r = potencia_total / 3.0
        potencia_s = potencia_total / 3.0
        potencia_t = potencia_total / 3.0

        # Query para insertar los datos en la tabla
        query = f"INSERT INTO `inst_bt_a1` (`unixtime`, `potencia_r`, `potencia_s`, `potencia_t`) " \
                f"VALUES ({timestamp_utc}, {potencia_r}, {potencia_s}, {potencia_t})"
        
        # Ejecutar la consulta
        cursor.execute(query)

# Confirmar los cambios y cerrar la conexión
connection.commit()
connection.close()

print("Inserción de datos completada.")
