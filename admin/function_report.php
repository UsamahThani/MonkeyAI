<?php
    // Include the database connection file
    include '../dbconnect.php';

    // Check if form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Escape user inputs for security
        $admin_name = $_POST['admin_name'];
        $location = $_POST['location'];
        $date = $_POST['date']; // Corrected to fetch date from form
        $time = $_POST['time'];
        $note = $_POST['note'];

        // Convert date format if needed
        $dateObj = DateTime::createFromFormat('d F Y', $date);
        if ($dateObj) {
            $formattedDate = $dateObj->format('Y-m-d');
        } else {
            $formattedDate = null;
        }

        if ($formattedDate) {
            // Prepare an insert statement
            $sql = "INSERT INTO report (report_location, report_date, report_time, report_context, report_admin) 
                    VALUES ('$location', '$formattedDate', '$time', '$note', '$admin_name')";

            if (mysqli_query($connect, $sql)) {
                $message = "Report submitted successfully.";
                $status = "success";
            } else {
                $message = "Error: " . mysqli_error($connect);
                $status = "error";
            }
        } else {
            $message = "Invalid date format.";
            $status = "error";
        }
    }

    // Close connection
    mysqli_close($connect);

    // Redirect to report_form.php with alert
    echo "<script type='text/javascript'>
            alert('$message');
            window.location.href = 'report_form.php';
          </script>";
?>
