import pyttsx3

engine = pyttsx3.init()
engine.setProperty("voice","es")

texto = """"
Hola Ama, estoy probando esto. Dale ama, amigate con la tecnología.
"""
engine.save_to_file(texto,"salida.mp3")
engine.runAndWait()

