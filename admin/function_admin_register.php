<?php
// Include database connection
require "../dbconnect.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $admin_name = $_POST['admin_name'];
    $admin_email = $_POST['email'];
    $admin_password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Handling profile image upload
    if (isset($_FILES['profileimg']) && $_FILES['profileimg']['error'] == 0) {
        $upload_dir = '../images/profile_img/';
        $image_ext = pathinfo($_FILES['profileimg']['name'], PATHINFO_EXTENSION);
        $image_name = uniqid() . '.' . $image_ext;
        $image_path = $upload_dir . $image_name;

        // Move the uploaded file to the specified directory
        if (move_uploaded_file($_FILES['profileimg']['tmp_name'], $image_path)) {
            // Image upload successful, proceed to insert into database
            $stmt = $connect->prepare("INSERT INTO admin (admin_name, admin_email, admin_password, admin_img) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $admin_name, $admin_email, $admin_password, $image_name);

            if ($stmt->execute()) {
                echo "<script>
                    alert('Admin registered successfully!');
                    window.location.href='usermanagement.php';
                </script>";
            } else {
                echo "<script>
                    alert('Error: " . addslashes($stmt->error) . "');
                    window.location.href='usermanagement.php';
                </script>";
            }

            $stmt->close();
        } else {
            echo "<script>
                alert('Failed to upload image.');
                window.location.href='usermanagement.php';
            </script>";
        }
    } else {
        echo "<script>
            alert('No image uploaded or there was an upload error.');
            window.location.href='usermanagement.php';
        </script>";
    }
}


$conn->close();
?>
