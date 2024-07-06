from simple_image_download import simple_image_download as simp # type: ignore

response = simp.simple_image_download

keyword = ["monkeys"]

for kw in keyword:
    response().download(kw, 200)