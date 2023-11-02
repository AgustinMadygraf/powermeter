import cv2
import tkinter as tk
from PIL import Image, ImageTk

# Función para mostrar la imagen procesada en la ventana
def show_frame():
    ret, frame = cap.read()
    if ret:
        # Procesa la imagen aquí si es necesario
        # Por ejemplo, convierte la imagen de BGR a RGB para mostrarla con PIL
        frame = cv2.cvtColor(frame, cv2.COLOR_BGR2RGB)
        img = Image.fromarray(frame)
        img = ImageTk.PhotoImage(image=img)
        panel.img = img
        panel.config(image=img)
        panel.after(10, show_frame)  # Actualiza la imagen cada 10 ms

# URL de la transmisión de video
video_url = 'rtsp://10.176.61.0:8080/h264.sdp'  #http://192.168.1.123:8080/videomgr.html
cap = cv2.VideoCapture(video_url)

root = tk.Tk()
root.title("Visualización de la imagen procesada")

# Crea un panel para mostrar la imagen
panel = tk.Label(root)
panel.pack(padx=10, pady=10)

show_frame()  # Inicia la función para mostrar la imagen

# Botón para cerrar la aplicación
quit_button = tk.Button(root, text="Cerrar", command=root.destroy)
quit_button.pack(padx=10, pady=10)

root.mainloop()
