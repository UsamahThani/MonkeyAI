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
            $email = $row["user_email"];
            $userName = $row["user_name"];
            $phonNum = $row["user_phonum"];
            $userImg = $row["user_img"];
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
    <link rel="stylesheet" href="edit.css">
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
                <li><a href="realtimevideo.php">Real time video</a></li>
                <li><a href="history.php">History</a></li>
                <li><a href="notifications.php">Notifications</a></li>
                <li><a href="profile.php">Profile</a></li>
            </ul>
        </nav>
    </header>
    <div class="main">
       
        <div class="data-container">
            <div class="user-data">
                <form action="function_updateProfile.php" method="post" enctype="multipart/form-data">
                    <label for="studNum">Student Number :</label>
                    <input type="text" name="studNum" value="<?php echo $studentNum ?>"><br><br>
                    <label for="email">Email :</label>
                    <input type="email" name="email" value="<?php echo $email ?>"><br><br>
                    <label for="email">Password :</label>
                    <input type="password" name="pass" value=""><br><br>
                    <label for="userName">Name :</label>
                    <input type="text" name="userName" value="<?php echo $userName ?>"><br><br>
                    <label for="phonNum">Phone Number :</label>
                    <input type="text" name="phonNum" value="<?php echo $phonNum ?>"><br><br>
                    <label for="userImg">Profile Image :</label>
                    <input type="file" name="userImg" ><br><br>

                    <input type="submit" value="Update">
                </form>
            </div>
        </div>
    </div>
</body>
</html>
