import schedule
import time
import pymysql
import minimalmodbus

# Puerto serie COM3 (ajusta el puerto según tu configuración)
com_port = 'COM4'

# Dirección del dispositivo Modbus (ajusta la dirección del dispositivo según tu configuración)
device_address = 1

# Direcciones de los registros que deseas leer (ajusta esto según tus necesidades)
# Entradas digitales
D1 = 70
D2 = 71
D3 = 72
D4 = 73

# Direcciones de los registros para controlar las salidas
K1 = 500
K2 = 501

# Configuración de la base de datos MySQL
db_config = {
    'host': 'localhost',
    'user': 'root',
    'password': '12345678',
    'db': 'novus'  # Base de datos y subíndice
}

# Función para verificar la conexión a la base de datos
def check_db_connection():
    try:
        connection = pymysql.connect(**db_config)
        return connection
    except Exception as e:
        print(f"Error de conexión a la base de datos: {e}")
        return None

# Función para leer una entrada digital
def read_digital_input(instrument, address):
    if instrument:
        try:
            result = instrument.read_bit(address, functioncode=2)
            return result
        except Exception as e:
            print(f"Error al leer entrada digital en registro {address}: {e}")
    return None

# Función para actualizar registros en la base de datos
def update_database(connection, address, value):
    if connection:
        try:
            with connection.cursor() as cursor:
                sql = f"UPDATE registros_modbus SET valor = {value} WHERE direccion_modbus = {address}"
                cursor.execute(sql)
                connection.commit()
                print(f"Registro actualizado: dirección {address}, valor {value}")
        except Exception as e:
            print(f"Error al actualizar el registro en la base de datos: {e}")

# Función para programar la lectura y control de salidas cada 1 segundo
def schedule_read_and_control():
    connection = check_db_connection()
    instrument = minimalmodbus.Instrument(com_port, device_address)
    
    if connection:
        D1_state = read_digital_input(instrument, D1)
        D2_state = read_digital_input(instrument, D2)
        D3_state = read_digital_input(instrument, D3)
        D4_state = read_digital_input(instrument, D4)

        if D1_state is not None:
            update_database(connection, 70, D1_state)
        
        if D2_state is not None:
            update_database(connection, 71, D2_state)
        
        if D3_state is not None:
            update_database(connection, 72, D3_state)

        if D4_state is not None:
            update_database(connection, 73, D4_state) 

# Programar la lectura y control de salidas cada 1 segundo
schedule.every(1).seconds.do(schedule_read_and_control)

while True:
    schedule.run_pending()
    time.sleep(1)
    print("")
