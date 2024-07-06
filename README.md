# Monkey AI

**Requested by:** Damia, student at UiTM  
**Developed by:** Mohamad Usamah Thani
**Project Duration:** July 2, 2024 - July 6, 2024

## Overview

Monkey AI is a cutting-edge project developed to enhance campus safety at UiTM by detecting the presence of monkeys around the university. Leveraging advanced AI and machine learning techniques, the system uses camera feeds to identify monkeys in real-time and alerts users immediately. This proactive approach helps in preventing potential disturbances and ensures a safer environment for students and staff.

## Features

- **Real-time Monkey Detection:** Utilizes YOLOv8m, a state-of-the-art object detection model, to accurately identify monkeys from live camera feeds.
- **User Alerts:** Instantly notifies users when a monkey is detected, allowing for timely intervention.
- **Web Interface:** A user-friendly web application developed with DeskApp and PHP to monitor and manage detection events.
- **Data Visualization:** Integrates ApexCharts to provide insightful visual analytics on monkey sightings and activities.

## Tools and Technologies

- **YOLOv8m:** For precise and efficient object detection.
- **DeskApp:** To create a responsive and intuitive web interface.
- **PHP:** Backend development for handling server-side logic and database interactions.
- **Python:** Employed for developing the AI model and integrating various system components.
- **ApexCharts:** To display detection statistics and trends through interactive charts.

## How It Works

1. **Camera Setup:** Surveillance cameras are installed around the campus to capture live video feeds.
2. **Detection Algorithm:** The video feeds are processed using the YOLOv8m model to detect monkeys in real-time.
3. **Alert System:** Upon detection, the system triggers alerts to notify users via the web interface.
4. **Data Analysis:** The detected events are logged and visualized using ApexCharts for monitoring and analysis purposes.

## Installation and Setup

1. **Clone the Repository:**
    ```sh
    git clone https://github.com/username/monkey-ai.git
    ```
2. **Install Dependencies:**
    - Python libraries: `pip install -r requirements.txt`
    - PHP and web dependencies as required.
3. **Configure Camera Feeds:** Set up the cameras and configure the video feed URLs in the application settings.
4. **Run the Application:** Start the web server and the detection algorithm.

## Contribution

Contributions to Monkey AI are welcome. Please fork the repository and submit a pull request with detailed descriptions of your changes.

## License

This project is licensed under the MIT License.

## Contact

For more information, please contact me at https://www.linkedin.com/in/usamahthani/.
