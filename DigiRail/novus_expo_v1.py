import serial.tools.list_ports
import serial  # Importa serial para capturar SerialException
import time
import minimalmodbus

def detect_serial_ports(device_description):
    available_ports = list(serial.tools.list_ports.comports())
    for port, desc, hwid in available_ports:
        if device_description in desc:
            return port
    return None

device_description = "DigiRail Connect"
com_port = detect_serial_ports(device_description)

if com_port:
    print(f"Puerto {device_description} detectado: {com_port}\n")
else:
    device_description = "USB-SERIAL CH340"
    com_port = detect_serial_ports(device_description)
    if com_port:
        print(f"Puerto detectado: {com_port}\n")
    else:
        print("No se detectaron puertos COM para tu dispositivo.")
        input("Presiona una tecla para salir")
        exit()

# Dirección del dispositivo Modbus (ajusta la dirección del dispositivo según tu configuración)
device_address = 1

# Direcciones de los registros que deseas leer (ajusta esto según tus necesidades)
# Entradas digitales
D1 = 70
D2 = 71

# Direcciones de los registros para controlar las salidas
K1 = 500
K2 = 501
K3 = 502
enclavamiento_k3 = False

# Función para encender y apagar una salida digital (registro)
def toggle_output(instrument, register, duration=0.1):
    try:
        instrument.write_bit(register, 1, functioncode=5)  # Enciende la salida
        time.sleep(duration)  # Espera un breve período
        instrument.write_bit(register, 0, functioncode=5)  # Apaga la salida
    except Exception as e:
        print(f"Error al escribir en salida digital en el registro {register}: {e}")

# Función para establecer las RPM de un motor en la salida analógica O1
def set_speed(instrument, speed_value):
    speed_register = 525  # Reemplaza XYZ con la dirección del registro de velocidad
    try:
        # El valor de 'speed' debe estar en el formato que el variador espera
        instrument.write_register(speed_register, speed_value, functioncode=16)
        print(f"Velocidad establecida a {speed_value}.")
    except Exception as e:
        print(f"Error al establecer la velocidad: {e}")

# Función para encender y apagar una salida digital (registro)
def toggle_output(instrument, register, duration=0.1, toggle=True):
    global enclavamiento_k3
    try:
        if toggle:
            # Enciende o apaga la salida basado en el enclavamiento
            state = 1 if not enclavamiento_k3 else 0
            instrument.write_bit(register, state, functioncode=5)
            if register == K3:
                enclavamiento_k3 = not enclavamiento_k3  # Cambia el estado del enclavamiento
        else:
            # Solo enciende la salida
            instrument.write_bit(register, 1, functioncode=5)
            time.sleep(duration)
            instrument.write_bit(register, 0, functioncode=5)
    except Exception as e:
        print(f"Error al escribir en salida digital en el registro {register}: {e}")       


# Crear una instancia de Instrumento Modbus o manejar errores
def create_instrument(com_port, device_address):
    try:
        return minimalmodbus.Instrument(com_port, device_address)
    except serial.SerialException as e:
        print(f"No se pudo abrir el puerto {com_port}: {e}")
        print("Por favor verifica la conexión para volver a intentar")
        return None

instrument = create_instrument(com_port, device_address)
while not instrument:
    print("")
    input("Presiona Enter para reintentar o escribe 'exit' para salir: ").lower()
    if input == 'exit':
        print("Saliendo del programa.")
        exit()
    instrument = create_instrument(com_port, device_address)


# Bucle principal para escuchar comandos de la consola

while True:
    command = input("Escribe un comando ('start', 'stop', 'invertir', 'speed', 'exit'): ").lower()
    if command == "start":
        toggle_output(instrument, K1, toggle=False)
    elif command == "stop":
        toggle_output(instrument, K2, toggle=False)
    elif command == "invertir":
        toggle_output(instrument, K3)  # Controla el enclavamiento de K3
    elif command == "speed":
        speed_value = int(input("Introduce la velocidad deseada en Hz "))
        speed_value = speed_value * 83.333333
        set_speed(instrument, speed_value)
    elif command == "exit":
        print("Saliendo del programa.")
        break
    else:
        print("Comando no reconocido.")