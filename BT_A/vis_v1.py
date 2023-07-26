import pandas as pd

print('visualización')

df = pd.read_csv('http://panel.powermeter.com.ar/descargar/directa/inst/56ae1c10-059b-4764-abec-f7bdc5e56603/')

# Sumar las columnas R:p, S:p y T:p
df['sum'] = df[['R:p', 'S:p', 'T:p']].sum(axis=1)

# Seleccionar las columnas que deseamos mostrar
df = df[['timestamp', 'R:p', 'S:p', 'T:p', 'sum']]

# Ordenar los datos por el timestamp en orden descendente
df = df.sort_values(by='timestamp', ascending=False)

# Obtener la cantidad de filas a mostrar
n = input("Ingrese la cantidad de filas que desea visualizar (o presione Enter para ver todas): ")
if n != "":
    df = df.head(int(n))

# Configuramos pandas para mostrar todas las filas
pd.set_option('display.max_rows', None)

print(df)

# Preguntamos al usuario si desea continuar
choice = input("Presione 'e' para salir o cualquier otra tecla para volver a ejecutar: ")

if choice.lower() == 'e':
    print("Saliendo del programa...")
else:
    # Llamamos al script nuevamente
    exec(open(__file__).read())
