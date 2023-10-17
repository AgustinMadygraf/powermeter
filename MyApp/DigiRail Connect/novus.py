from pymodbus.client import ModbusSerialClient
import schedule
import time

# Puerto serie (ajusta el puerto según tu configuración)
serial_port = 'COM13'  # Puerto COM13, ajústalo según tu configuración

# Dirección del dispositivo Modbus (ajusta la dirección del dispositivo según tu configuración)
device_address = 1

# Direcciones de los registros que deseas leer (ajusta esto según tus necesidades)
# Entradas digitales
D1 = 70
D2 = 71
D3 = 72
D4 = 73
print("Iniciando")

# Función para verificar la conexión
def check_connection(port, address):
    try:
        client = ModbusSerialClient(method='rtu', port=port, stopbits=2, bytesize=8, parity='N', baudrate=9600)
        client.connect()
        if client.is_socket_open():
            print("Conexión exitosa al dispositivo Modbus")
        return client
    except Exception as e:
        print(f"Error de conexión: {e}")
        return None

# Función para leer una entrada digital
def read_digital_input(client, address):
    if client:
        try:
            result = client.read_discrete_inputs(address, 1, unit=device_address)
            if result.bits:
                return result.bits[0]
            else:
                print(f"Error al leer entrada digital en registro {address}: No se recibieron bits")
        except Exception as e:
            print(f"Error al leer entrada digital en registro {address}: {e}")
    return None

# Función para programar la lectura cada 1 segundo
def schedule_read():
    client = check_connection(serial_port, device_address)
    if client:
        D1_state = read_digital_input(client, D1)

        if D1_state is not None:
            print(f"Estado de D1: {D1_state}")

# Programar la lectura cada 1 segundo
schedule.every(1).seconds.do(schedule_read)

while True:
    schedule.run_pending()
    time.sleep(1)

