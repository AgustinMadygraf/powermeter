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

# Función para encender y apagar una salida digital (registro)
def toggle_output(instrument, register, duration=0.1):
    try:
        instrument.write_bit(register, 1, functioncode=5)  # Enciende la salida
        time.sleep(duration)  # Espera un breve período
        instrument.write_bit(register, 0, functioncode=5)  # Apaga la salida
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
    command = input("Escribe 'start' para encender D1, 'stop' para encender D2, o 'exit' para salir: ").lower()
    if command == "start":
        toggle_output(instrument, K1)
    elif command == "stop":
        toggle_output(instrument, K2)
    elif command == "exit":
        print("Saliendo del programa.")
        break
    else:
        print("Comando no reconocido.")
