from pymodbus.client import ModbusSerialClient
import schedule
import time

# Puerto serie COM13 (ajusta el puerto según tu configuración)
com_port = 'COM13'

# Dirección del dispositivo Modbus (ajusta la dirección del dispositivo según tu configuración)
device_address = 1

# Direcciones de los registros que deseas leer (ajusta esto según tus necesidades)
# Entradas digitales
D1 = 70
D2 = 73
D3 = 72

# Direcciones de los registros para controlar las salidas
K1 = 500

# Variables para rastrear el estado de las entradas y la retención de K1
d3_state = False
k1_state = False

# Función para verificar la conexión
def check_connection(port, address):
    try:
        client = ModbusSerialClient(method='rtu', port=port, stopbits=1, bytesize=8, parity='N', baudrate=9600)
        client.connect()
        return client
    except Exception as e:
        print(f"Error de conexión: {e}")
        return None

# Función para leer una entrada digital
def read_digital_input(client, address):
    if client:
        try:
            result = client.read_bit(address, 1, unit=device_address)
            return result.bits[0]
        except Exception as e:
            print(f"Error al leer entrada digital en registro {address}: {e}")
    return None

# Función para escribir en una salida digital (K1)
def write_digital_output(client, address, value):
    global k1_state
    if client:
        try:
            client.write_bit(address, value, unit=device_address)
            k1_state = value
            print(f"La salida {address} configurada a {value}")
        except Exception as e:
            print(f"Error al escribir en salida digital en registro {address}: {e}")

# Función para programar la lectura y control de salidas cada 1 segundo
def schedule_read_and_control():
    client = check_connection(com_port, device_address)
    if client:
        D1_state = read_digital_input(client, D1)
        D2_state = read_digital_input(client, D2)
        D3_state = read_digital_input(client, D3)

        if D3_state is not None:
            d3_state = D3_state

        if D1_state is not None and D2_state is not None:
            if D1_state and D2_state:
                write_digital_output(client, K1, True)
            else:
                if not d3_state:
                    write_digital_output(client, K1, False)

# Programar la lectura y control de salidas cada 1 segundo
schedule.every(1).seconds.do(schedule_read_and_control)

while True:
    schedule.run_pending()
    time.sleep(1)
