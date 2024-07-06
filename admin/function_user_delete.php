<?php
session_start();
require "../dbconnect.php";

if (isset(($_GET['userId']))) {
    $user_id = $_GET['userId'];

    if ($_GET['userType'] == "student") {
        $studQ = "DELETE FROM user WHERE user_id = ?";
        $studStmt = $connect->prepare($studQ);
        $studStmt->bind_param("i", $user_id);

        if ($studStmt -> execute()) {
            echo "<script type='text/javascript'> alert('Student deleted successfully!'); window.location.href = 'usermanagement.php'; </script>";
        } else {
            echo "<script type='text/javascript'> alert('Delete student failed!'); window.location.href = 'usermanagement.php'; </script>";
        }

        $studStmt->close();
    } else {
        $adminQ = "DELETE FROM admin WHERE admin_id = ?";
        $adminStmt = $connect->prepare($adminQ);
        $adminStmt->bind_param("i", $user_id);

        if ($adminStmt -> execute()) {
            echo "<script type='text/javascript'> alert('Admin deleted successfully!'); window.location.href = 'usermanagement.php'; </script>";
        } else {
            echo "<script type='text/javascript'> alert('Delete admin failed!'); window.location.href = 'usermanagement.php'; </script>";
        }

        $adminStmt->close();
    }
}else {
    // Set error message if report_id is not provided
    $_SESSION['error_message'] = "No user ID provided.";
}

?>