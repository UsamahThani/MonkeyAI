from ultralytics import YOLO

model = YOLO("yolov8m_custom.pt")

model.predict(source="0", show=True, save=True, conf=0.5, line_thickness=1)