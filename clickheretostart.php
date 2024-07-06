<?php
session_start();
if (isset($_SESSION["user"])) {
   header("Location: clickheretostart.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Get started| Monkey Detection System </title>
    <!-- Google Fonts Link For Icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,0,0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="homepage.css">
    <script src="script.js" defer></script>
</head>
<body>
    <header>
        <nav class="navbar">
            <span class="hamburger-btn material-symbols-rounded">menu</span>
            <a href="#" class="logo">
                <img src="images/monkeylogo.jpg" alt="logo">
                <h2>Monkey Detection System</h2>
            </a>
            <ul class="links">
                <span class="close-btn material-symbols-rounded">close</span>
                <li><a href="clickheretostart.php">Home</a></li>
                <li><a href="http://192.168.1.100:5000/">Real time video</a></li> <div class="blur-bg-overlay"></div>
                <li><a href="history.php">History</a></li>
                <li><a href="profile.php">Profile</a></li> <div class="blur-bg-overlay"></div>
            </ul>
        </nav>
    </header>
    <div class="main">
        <br>
        <div class="container">
            <div class="content">
                <h3>MONKEY DETECTION SYSTEM USING YOLO</h3>
                <p>The issue of wild monkey presence in college locations has grown in importance, especially for students. Disturbances caused by
    wild monkeys not only frustrated the peace of the college campus but also present real-world issues that have an impact on the
    well-being of students. As a result, it is crucial to address the issue of wild monkey disturbance, which will result in the creation
    of a crucial Monkey Detection System using YOLO.</p>
            </div>
            <div class="content">
                <h3>ABOUT</h3>
                <p>The Monkey Detection System leverages YOLO's object detection capabilities to accurately identify monkeys in real-time videos
                with results with high accuracy.</p>
            </div>
        </div>
    </div>
</body>
</html>