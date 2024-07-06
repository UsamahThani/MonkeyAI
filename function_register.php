<?php
session_start();
require "dbconnect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    // Check if the email already exists
    $checkQuery = "SELECT * FROM user WHERE user_email = ?";
    $stmt = $connect->prepare($checkQuery);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        header("Location: index.php?error=Email already registered");
        exit();
    }

    $query = "INSERT INTO user (user_email, user_pass) VALUES (?, ?)";
    $stmt = $connect->prepare($query);
    $stmt->bind_param("ss", $email, $hashedPassword);

    if ($stmt->execute()) {
        echo "<script>alert('New user registered! You can log in now.'); window.location.href = 'index.php';</script>";
    } else {
        header("Location: index.php?error=Registration failed");
        exit();
    }
}
?>
