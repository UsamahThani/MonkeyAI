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
    <title>Real-time video | Monkey Detection Detection System </title>
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
                <li><a href="notifications.php">Notifications</a></li>
                <li><a href="profile.php">Profile</a></li> <div class="blur-bg-overlay"></div>
            </ul>
    </header>
    <div class="main">

    </div>
</body>
</html>