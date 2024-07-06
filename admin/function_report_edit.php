<?php
session_start();
require "../dbconnect.php";

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize form data
    $admin_name = mysqli_real_escape_string($connect, $_POST['admin_name']);
    $location = mysqli_real_escape_string($connect, $_POST['location']);
    $date = mysqli_real_escape_string($connect, $_POST['date']);
    $time = mysqli_real_escape_string($connect, $_POST['time']);
    $note = mysqli_real_escape_string($connect, $_POST['note']);
    $report_id = mysqli_real_escape_string($connect, $_POST['report_id']);

    // Validate form data (you can add more validation as needed)
    if (empty($admin_name) || empty($location) || empty($date) || empty($time) || empty($note)) {
        // Redirect with error message if validation fails
        $_SESSION['error_message'] = "All fields are required.";
        header("Location: report_form.php");
        exit();
    }

    // Prepare the SQL update query
    $query = "UPDATE report SET report_admin = ?, report_location = ?, report_date = ?, report_time = ?, report_context = ? WHERE report_id = ?";
    $stmt = $connect->prepare($query);
    $stmt->bind_param("sssssi", $admin_name, $location, $date, $time, $note, $report_id);

    // Execute the query and check for success
    if ($stmt->execute()) {
        // Redirect with success message if the update was successful
        echo "<script type='text/javascript'> alert('Report updated successfully!'); window.location.href = 'report.php'; </script>";
    } else {
        // Redirect with error message if the update failed
        echo "<script type='text/javascript'> alert('Update report failed!'); window.location.href = 'report.php'; </script>";
    }

    // Close the statement and connection
    $stmt->close();
    $connect->close();
} else {
    // Redirect to the report form if the request method is not POST
    header("Location: report_form_edit.php");
}
?>
