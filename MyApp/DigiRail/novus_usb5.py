import pymysql
import minimalmodbus
import serial.tools.list_ports
import time
import sys

def detect_serial_ports(device_description):
    available_ports = list(serial.tools.list_ports.comports())
    for port, desc, hwid in available_ports:
        if device_description in desc:
            return port
    return None

device_description = "DigiRail Connect"  # Modifica esto según la descripción de tu dispositivo
com_port = detect_serial_ports(device_description)

if com_port:
    print(f"Puerto detectado: {com_port}\n")
    input("Presione una tecla para continuar")
else:
    print("No se detectaron puertos COM para tu dispositivo.")
    input ("Presiona una tecla para salir")
    exit

# Dirección del dispositivo Modbus (ajusta la dirección del dispositivo según tu configuración)
device_address = 1

# Entradas digitales
D1 = 70
D2 = 71
D3 = 72
D4 = 73

# Contador
HR_COUNTER1_LO = 22
HR_COUNTER1_HI = 23
HR_COUNTER2_LO = 24
HR_COUNTER2_HI = 25
HR_COUNTER3_LO = 26
HR_COUNTER3_HI = 27
HR_COUNTER4_LO = 28
HR_COUNTER4_HI = 29

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

# Función para leer registros de alta resolución
def read_high_resolution_register(instrument, address_lo, address_hi):
    if instrument:
        try:
            value_lo = instrument.read_register(address_lo, functioncode=3)
            value_hi = instrument.read_register(address_hi, functioncode=3)
            return value_lo, value_hi
        except Exception as e:
            print(f"Error al leer registro de alta resolución en registros {address_lo} y {address_hi}: {e}")
    return None, None

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

while True:
    sys.stdout.write("\033[H\033[J")

    # Realiza tus operaciones de lectura y actualización aquí.
    connection = check_db_connection()
    instrument = minimalmodbus.Instrument(com_port, device_address)

    if connection:
        D1_state = read_digital_input(instrument, D1)
        D2_state = read_digital_input(instrument, D2)
        D3_state = read_digital_input(instrument, D3)
        D4_state = read_digital_input(instrument, D4)

        HR_COUNTER1_lo, HR_COUNTER1_hi = read_high_resolution_register(instrument, HR_COUNTER1_LO, HR_COUNTER1_HI)
        HR_COUNTER2_lo, HR_COUNTER2_hi = read_high_resolution_register(instrument, HR_COUNTER2_LO, HR_COUNTER2_HI)
        HR_COUNTER3_lo, HR_COUNTER3_hi = read_high_resolution_register(instrument, HR_COUNTER3_LO, HR_COUNTER3_HI)
        HR_COUNTER4_lo, HR_COUNTER4_hi = read_high_resolution_register(instrument, HR_COUNTER4_LO, HR_COUNTER4_HI)

        if D1_state is not None:
            update_database(connection, D1, D1_state)
        if D2_state is not None:
            update_database(connection, D2, D2_state)
        if D3_state is not None:
            update_database(connection, D3, D3_state)
        if D4_state is not None:
            update_database(connection, D4, D4_state)

        if HR_COUNTER1_lo is not None and HR_COUNTER1_hi is not None:
            update_database(connection, HR_COUNTER1_LO, HR_COUNTER1_lo)
            update_database(connection, HR_COUNTER1_HI, HR_COUNTER1_hi)
        if HR_COUNTER2_lo is not None and HR_COUNTER2_hi is not None:
            update_database(connection, HR_COUNTER2_LO, HR_COUNTER2_lo)
            update_database(connection, HR_COUNTER2_HI, HR_COUNTER2_hi)
        if HR_COUNTER3_lo is not None and HR_COUNTER3_hi is not None:
            update_database(connection, HR_COUNTER3_LO, HR_COUNTER3_lo)
            update_database(connection, HR_COUNTER3_HI, HR_COUNTER3_hi)
        if HR_COUNTER4_lo is not None and HR_COUNTER4_hi is not None:
            update_database(connection, HR_COUNTER4_LO, HR_COUNTER4_lo)
            update_database(connection, HR_COUNTER4_HI, HR_COUNTER4_hi)
    
    time.sleep(1)
