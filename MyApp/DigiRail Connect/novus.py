import minimalmodbus

# Puerto serie COM3 (ajusta el puerto según tu configuración)
com_port = 'COM3'

# Dirección del dispositivo Modbus (ajusta la dirección del dispositivo según tu configuración)
device_address = 1

# Dirección del registro que deseas leer (ajusta esto según tus necesidades)
input_register_address = 70  # Por ejemplo, para leer HR_INPUT1_STATE

# Función para verificar la conexión
def check_connection(port, address):
    try:
        instrument = minimalmodbus.Instrument(port, address)
        instrument.serial.baudrate = 9600  # Ajusta la velocidad de baudios según tu configuración
        instrument.serial.timeout = 1.0  # Ajusta el tiempo de espera según tu configuración
        return instrument
    except Exception as e:
        print(f"Error de conexión: {e}")
        return None

# Función para leer una entrada digital
def read_digital_input(instrument, address):
    if instrument:
        try:
            result = instrument.read_bit(address, functioncode=2)  # Utiliza la función 2 para leer bits
            return result
        except Exception as e:
            print(f"Error al leer entrada digital: {e}")
    return None

if __name__ == '__main__':
    instrument = check_connection(com_port, device_address)
    if instrument:
        input_state = read_digital_input(instrument, input_register_address)
        if input_state is not None:
            print(f"Estado de la entrada digital en registro {input_register_address}: {input_state}")
