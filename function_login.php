<?php
session_start();
require "dbconnect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $user_type = $_POST['user_type'];

    $email = filter_var($email, FILTER_SANITIZE_EMAIL);

    if ($user_type == 'admin') {
        $query = "SELECT * FROM admin WHERE admin_email = ?";
    } else {
        $query = "SELECT * FROM user WHERE user_email = ?";
    }

    $stmt = $connect->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result) {
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $hashedPassword = ($user_type == 'admin') ? $row["admin_password"] : $row["user_pass"];

            if (password_verify($password, $hashedPassword)) {
                $_SESSION["user_email"] = $email;
                $_SESSION["user_id"] = ($user_type == 'admin') ? $row["admin_id"] : $row["user_id"];

                if ($user_type == 'admin') {
                    header("Location: admin/index.php");
                } else {
                    header("Location: clickheretostart.php");
                }
                exit();
            } else {
                header("Location: index.php?error=Invalid password");
                exit();
            }
        } else {
            header("Location: index.php?error=No account found with that email address");
            exit();
        }
    } else {
        header("Location: index.php?error=Database query failed");
        exit();
    }
}
?>
