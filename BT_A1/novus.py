from pymodbus.client.sync import ModbusTcpClient

# Dirección IP del dispositivo Modbus TCP
server_ip = "192.168.1.55"

# Crea un cliente Modbus TCP
client = ModbusTcpClient(server_ip)

try:
    # Conectarse al servidor Modbus
    if client.connect():
        # Leer el estado de un registro (por ejemplo, registro 0)
        result = client.read_coils(0, 1)

        # Mostrar el resultado
        if result.isError():
            print("Error:", result)
        else:
            print("Estado del registro:", result.bits[0])
    else:
        print("No se pudo conectar al servidor Modbus")
finally:
    # Cerrar la conexión
    client.close()
