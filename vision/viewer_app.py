#viewer_app.py
import cv2
import tkinter as tk
from PIL import Image, ImageTk

# Declarar cap como una variable global
cap = None

def start_video_stream():
    global cap, video_url
    video_url = entry.get()
    cap = cv2.VideoCapture(video_url)
    show_frame()

def show_frame():
    global cap  # Acceder a la variable cap global
    ret, frame = cap.read()
    if ret:
        frame = cv2.cvtColor(frame, cv2.COLOR_BGR2RGB)
        img = Image.fromarray(frame)
        img = ImageTk.PhotoImage(image=img)
        panel.img = img
        panel.config(image=img)
        panel.after(10, show_frame)

root = tk.Tk()
root.title("Visualización de la imagen procesada")

# Crea una entrada de texto para la URL con valor predeterminado
default_video_url = "rtsp://10.176.61.0:8080/h264.sdp"
entry = tk.Entry(root)
entry.insert(0, default_video_url)
entry.pack(padx=10, pady=10)

# Botón para iniciar la visualización
start_button = tk.Button(root, text="Iniciar visualización", command=start_video_stream)
start_button.pack(padx=10, pady=10)

# Crea un panel para mostrar la imagen
panel = tk.Label(root)
panel.pack(padx=10, pady=10)

root.mainloop()
