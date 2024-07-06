<?php
session_start();
require "../dbconnect.php";

if (isset($_GET['reportId'])) {
    $report_id = $_GET['reportId'];

    // Prepare a DELETE statement
    $query = "DELETE FROM report WHERE report_id = ?";
    $stmt = $connect->prepare($query);
    $stmt->bind_param("i", $report_id);

    if ($stmt->execute()) {
        // Set success message
        echo "<script type='text/javascript'> alert('Report deleted successfully!'); window.location.href = 'report.php'; </script>";
    } else {
        // Set error message
        echo "<script type='text/javascript'> alert('Delete report failed!'); window.location.href = 'report.php'; </script>";
    }

    // Close the statement
    $stmt->close();
} else {
    // Set error message if report_id is not provided
    $_SESSION['error_message'] = "No report ID provided.";
}

// Redirect back to report.php
header("Location: report.php");
exit();
?>
