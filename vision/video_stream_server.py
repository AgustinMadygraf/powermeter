from flask import Flask, Response
import cv2
import image_processing  # Importa tu archivo image_processing.py

app = Flask(__name__)

# Inicializa el objeto 'cap' para capturar el video de la URL RTSP
video_url = "rtsp://10.176.61.0:8080/h264.sdp"
cap = cv2.VideoCapture(video_url)

@app.route('/video_feed')
def video_feed():
    def generate():
        while True:
            ret, frame = cap.read()
            if ret:
                processed_frame = image_processing.process_image(frame)  # Procesa la imagen con tu función
                _, buffer = cv2.imencode('.jpg', processed_frame)
                yield (b'--frame\r\n'
                       b'Content-Type: image/jpeg\r\n\r\n' + buffer.tobytes() + b'\r\n')

    return Response(generate(), mimetype='multipart/x-mixed-replace; boundary=frame')

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000)
