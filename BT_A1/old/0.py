import os
import requests
import time
import csv


print('actualizar MySQL desde datos.csv')
print("")
# si presiona la tecla "Y" actualiza la base de datos ejecutando upd_datos_csv.py 
# si presiona cualquier otra tecla continía sin ejecutar ningun otro comando
print('El proceso de actualización de todos los resgistro puede tomar unos minutos')
n = input('¿Desea actualizar datos.csv con los registros de los últimos 7 días? (Y/N)')
if n.lower() == 'y':
    # Ejecuta el archivo upd_datos_csv.py para actualizar la base de datos con los registros de los últimos 7 días
    exec(open("upd_datos_csv_inst.py").read())
    print("A continuación se enviarán todos los registros desde 'datos_inst.csv' hacia MySQL")
    time.sleep(1)     
    print("")
    exec(open("upd_sql_all_inst.py").read())
    print("")
    time.sleep(1)     

else:
    print("")
    print('Continuando sin actualizar datos_inst.csv')
print("")
n = input("presione la tecla [ENTER] para ACTUALIZAR automaticamente cada 5 minutos; \npresione la tecla [x] seguido de [ENTER] para SALIR")
if n.lower() == 'x':
    print("")    
    print("saliendo")
    time.sleep(1) 
    exit()
a = 0  
while True:
    print("")
    print(f"Actualizacion numero ",a, "                                           ")
    print("")
    time.sleep(1)
    a = a + 1
    def cuenta_regresiva(segundos):
        for i in range(segundos, 0, -1):
            print(f"Actualizando en {i} segundos...", end="\r")
            time.sleep(1)
    print('actualización de MySQL desde datos.csv')
    time.sleep(1)
    exec(open("upd_datos_csv_inst.py").read())
    time.sleep(1)
    print("")
    exec(open("upd_sql_fast_inst.py").read())
    cuenta_regresiva(300)


