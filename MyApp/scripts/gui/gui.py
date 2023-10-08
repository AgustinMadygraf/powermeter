#gui.py
import tkinter as tk
from tkinter import filedialog
import json
import os
import sys
import datetime
sys.path.append(os.path.join(os.path.dirname(__file__), '..'))
from data import data_reader, data_validator
import server_communication
import main



# Crear una clase personalizada para redirigir la salida a Text widget
class OutputRedirector:
    def __init__(self, text_widget):
        self.text_widget = text_widget

    def write(self, text):
        self.text_widget.insert(tk.END, text)

# Restaurar sys.stdout para que la salida futura vaya a la consola
def restore_stdout():
    sys.stdout = sys.__stdout__

# Obtener la ubicación del script gui_v1.py
config_file_path = "C:/config_python/config.json"
print("")
print("-")
print("")
print("config_file_path: ",config_file_path)
print("")
print("-")
print("")
# Cargar la URL predeterminada desde el archivo de configuración
try:
    with open(config_file_path, 'r') as config_file:
        config_data = json.load(config_file)
        default_url = config_data.get('default_url', '')
except FileNotFoundError:
    default_url = "URL predeterminada no encontrada"

def seleccionar_archivo():
    file_path = filedialog.askopenfilename(filetypes=[("Archivos CSV", "*.csv")])
    ubicacion_csv.delete(0, tk.END)
    ubicacion_csv.insert(0, file_path)

    # Actualizar el valor del archivo CSV en el archivo JSON
    config_data['CSV_file'] = file_path
    with open(config_file_path, 'w') as config_file:
        json.dump(config_data, config_file, indent=4)

def ubicacion_por_defecto():
    ubicacion_csv.delete(0, tk.END)
    ubicacion_csv.insert(0, default_url)

    # Actualizar el valor del archivo CSV en el archivo JSON
    config_data['CSV_file'] = default_url
    with open(config_file_path, 'w') as config_file:
        json.dump(config_data, config_file, indent=4)

def enviar_datos():
    # Limpiar el campo de respuesta del servidor
    respuesta_servidor.config(state=tk.NORMAL)
    respuesta_servidor.delete(1.0, tk.END)
    
    # Llamar a main.py
    try:
        # Redirigir la salida a Text widget
        output_redirector = OutputRedirector(respuesta_servidor)
        sys.stdout = output_redirector
        main.main()
    except Exception as e:
        respuesta_servidor.insert(tk.END, f"Error al ejecutar main.py: {e}\n")
    finally:
        # Restaurar sys.stdout para que la salida futura vaya a la consola
        restore_stdout()

def salir():
    ubicacion_por_defecto()  
    root.destroy()

root = tk.Tk()
root.geometry("{0}x{1}+0+0".format(root.winfo_screenwidth(), root.winfo_screenheight()))  # Maximizar la ventana

root.title("Interfaz de Envío de Datos")



# Crear un Frame para los botones "Ubicación por Defecto" y "Seleccionar archivo CSV"
botones_frame = tk.Frame(root)
botones_frame.pack()

# Botón "Ubicación por Defecto"
boton_ubicacion_defecto = tk.Button(botones_frame, text="Ubicación por Defecto", command=ubicacion_por_defecto)
boton_ubicacion_defecto.pack(side=tk.LEFT, padx=10)  # Colocar a la izquierda y agregar un espaciado

# Botón "Seleccionar archivo CSV"
boton_seleccionar = tk.Button(botones_frame, text="Seleccionar archivo CSV", command=seleccionar_archivo)
boton_seleccionar.pack(side=tk.LEFT, padx=10)  # Colocar a la izquierda y agregar un espaciado

etiqueta_ubicacion = tk.Label(root, text="Ubicación del CSV:")
etiqueta_ubicacion.pack()

ubicacion_csv = tk.Entry(root, width=90)
ubicacion_csv.insert(0, default_url)
ubicacion_csv.pack()

boton_enviar = tk.Button(root, text="Enviar Datos", command=enviar_datos)
boton_enviar.pack()

etiqueta_respuesta = tk.Label(root, text="Respuesta del servidor:")
etiqueta_respuesta.pack()

# Agregar un Canvas para el campo de respuesta_servidor
canvas = tk.Canvas(root)
canvas.pack()

scrollbar = tk.Scrollbar(root, command=canvas.yview)
scrollbar.pack(side=tk.RIGHT, fill=tk.Y)
canvas.configure(yscrollcommand=scrollbar.set)

respuesta_servidor = tk.Text(canvas, height=20, width=120)
respuesta_servidor.pack()

boton_salir = tk.Button(root, text="Salir", command=salir)
boton_salir.pack()

ubicacion_por_defecto()  

root.mainloop()
