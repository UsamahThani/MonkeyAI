from ultralytics import YOLO # type: ignore

model = YOLO("yolov8m.pt")

model.train(data="data=yolov8_custom/data_custom.yaml", batch=4, imgsz=640, epochs=100, monkeys=1)