# image_processing.py
import cv2
import numpy as np

def process_image(frame):
    # Realiza el procesamiento de la imagen aquí

    # Supongamos que la imagen tiene un tamaño conocido (ancho y alto en píxeles)
    image_width = frame.shape[1]
    image_height = frame.shape[0]

    # Define la escala de conversión de píxeles a milímetros
    pixels_per_mm = 4 

    # Dibuja una regla en la parte inferior de la imagen
    cv2.line(frame, (0, image_height - 30), (image_width, image_height - 30), (255, 0, 0), 2)  # Línea azul

    # Dibuja una regla en la parte superior de la imagen
    cv2.line(frame, (0, 30), (image_width, 30), (255, 0, 0), 2)  # Línea azul

    # Agrega valores de milímetros en la regla en la parte inferior
    for mm in range(-10, 121, 10):
        x = (mm + 10) * pixels_per_mm  # Suma 10 para desplazarlo a la derecha
        cv2.line(frame, (x, image_height - 40), (x, image_height - 20), (0, 0, 255), 1)  # Línea roja (milímetros)
        cv2.putText(frame, f"{mm} ", (x, image_height - 10), cv2.FONT_HERSHEY_SIMPLEX, 0.4, (0, 0, 255), 1)

    # Agrega valores de milímetros en la regla en la parte superior
    for mm in range(-10, 121, 10):
        x = (mm + 10) * pixels_per_mm  # Suma 10 para desplazarlo a la derecha
        cv2.line(frame, (x, 10), (x, 30), (0, 0, 255), 1)  # Línea roja (milímetros)
        cv2.putText(frame, f"{mm} ", (x, 10), cv2.FONT_HERSHEY_SIMPLEX, 0.4, (0, 0, 255), 1)

    for mm in range(12, 261, 10):
        x = (mm + 10) * 2  # Suma 10 para desplazarlo a la derecha
        half_x = x - (5)  # Calcula la posición para la línea de la mitad
        y_bottom = image_height - 40
        y_top = 30

        # Dibuja las líneas adicionales de la mitad de largo en verde
        cv2.line(frame, (half_x, y_bottom), (half_x, y_top), (0, 255, 0), 1)

    return frame
