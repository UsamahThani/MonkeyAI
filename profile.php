<?php
    session_start();
    require "dbconnect.php";
    $session_email = $_SESSION["user_email"];
    $session_id = $_SESSION["user_id"];

    $profileSQL = "SELECT * FROM user WHERE user_id = '$session_id'";
    $profileResult = mysqli_query($connect, $profileSQL);

    if ($profileResult) {
        if ($row = mysqli_fetch_array($profileResult)) {
            $studentNum = $row["student_num"];
            $userName = $row["user_name"];
            $phonNum = $row["user_phonum"];
            $userImg = $row["user_img"];
        }
    }

    function checkImg($userImg) {
        if ($userImg == null || empty($userImg)) {
            echo "default_proImg.jpg";
        } else {
            echo $userImg;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website with Login & Signup Form | Monkey Detection System</title>
    <!-- Google Fonts Link For Icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,0,0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="profile.css">
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
                <li><a href="http://192.168.1.100:5000/">Real time video</a></li>
                <li><a href="history.php">History</a></li>
                <li><a href="profile.php">Profile</a></li>
            </ul>
        </nav>
    </header>
    <div class="img-container">
        <img src="images/profile_img/<?php checkImg($userImg) ?>" alt="profileImg" class="profile-img">
    </div>
    <div class="main ofHidden">
        <div class="btn-container">
            <button class="editBtn" onclick="window.location.href='profileEdit.php'">
                <span class="circle1"></span>
                <span class="circle2"></span>
                <span class="circle3"></span>
                <span class="circle4"></span>
                <span class="circle5"></span>
                <span class="text">Edit Profile</span>
            </button>
            <button class="logoutBtn" onclick="window.location.href='function_logout.php'">
                <span class="circle1"></span>
                <span class="circle2"></span>
                <span class="circle3"></span>
                <span class="circle4"></span>
                <span class="circle5"></span>
                <span class="text">Logout</span>
            </button>
        </div>
        <div class="name-container"><?php echo $userName ?></div>
        <div class="data-container">
            <div class="user-data">
                <p><strong>E-mail</strong>: <?php echo $session_email ?></p>
                <p><strong>Student ID</strong>: <?php echo $studentNum ?></p>
                <p><strong>Phone Number</strong>: <?php echo $phonNum ?></p>
            </div>
        </div>
    </div>
</body>
</html>
