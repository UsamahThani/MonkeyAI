from flask import Flask, render_template, Response
import cv2
from ultralytics import YOLO
import threading

app = Flask(__name__)
cap = cv2.VideoCapture(0)

# Load the model once
model = YOLO(r"C:\xampp\htdocs\MonkeyAI\yolov8_custom\yolov8m_custom.pt")

def generate():
    while True:
        ret, frame = cap.read()
        if ret:
            # Predict with adjusted confidence threshold
            result = model.predict(frame, device="cuda", conf=0.5, iou=0.5)
            frame = result[0].plot()

            # Encode the frame in JPEG format
            (flag, encodedImage) = cv2.imencode(".jpg", frame)
            if not flag:
                continue

            yield (b'--frame\r\n'
                   b'Content-Type: image/jpeg\r\n\r\n' +
                   bytearray(encodedImage) + b'\r\n')
        else:
            break

@app.route("/")
def index():
    return render_template("aidetection.html")

@app.route("/video_feed")
def video_feed():
    return Response(generate(),
                    mimetype="multipart/x-mixed-replace; boundary=frame")

if __name__ == "__main__":
    app.run(host='0.0.0.0', debug=False, threaded=True)
