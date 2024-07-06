<?php
session_start();
require "../dbconnect.php";

// Function to update admin image
function updateAdminImage($adminImg) {
    $errors = [];
    $uploadedFileName = "";

    // Check if a new image file is uploaded
    if ($adminImg['error'] == 0) {
        $allowedTypes = ['image/jpeg', 'image/png'];
        $fileType = mime_content_type($adminImg['tmp_name']);
        if (!in_array($fileType, $allowedTypes)) {
            $errors[] = "Only JPG and PNG files are allowed.";
        } else {
            $extension = pathinfo($adminImg['name'], PATHINFO_EXTENSION);
            $uploadedFileName = uniqid() . '.' . $extension;
            $uploadDir = '../images/profile_img/';
            $uploadFilePath = $uploadDir . $uploadedFileName;
            if (!move_uploaded_file($adminImg['tmp_name'], $uploadFilePath)) {
                $errors[] = "Failed to upload image.";
            }
        }
    }

    // Return uploaded file name if successfully uploaded
    return $uploadedFileName ?: null;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $adminName = $_POST['admin_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $adminImg = $_FILES['profileimg'];

    // Fetch the admin_id from POST
    $admin_id = $_POST['admin_id'];

    // Update admin image if provided
    $uploadedFileName = updateAdminImage($adminImg);

    // Prepare the SQL statement
    $sql = "UPDATE admin SET 
                admin_name = ?, 
                admin_email = ?";

    // Hash the password if it's not empty
    if (!empty($password)) {
        $hashedPass = password_hash($password, PASSWORD_DEFAULT);
        $sql .= ", admin_password = ?";
    } else {
        $hashedPass = null; // Ensure no password update if empty
    }

    // Append admin image update if provided
    if ($uploadedFileName !== null) {
        $sql .= ", admin_img = ?";
    }

    $sql .= " WHERE admin_id = ?";

    // Prepare the statement
    $stmt = $connect->prepare($sql);

    if (!$stmt) {
        echo "Prepare failed: (" . $connect->errno . ") " . $connect->error;
        exit;
    }

    // Bind parameters
    $bindParams = [$adminName, $email];

    // Bind password parameter if updated
    if (!empty($password)) {
        $bindParams[] = $hashedPass;
    }

    // Bind image parameter if updated
    if ($uploadedFileName !== null) {
        $bindParams[] = $uploadedFileName;
    }

    // Add admin_id as the last parameter
    $bindParams[] = $admin_id;

    // Determine bind types dynamically
    $bindTypes = str_repeat('s', count($bindParams) - 1) . 'i';
    $bindParamsRefs = array_merge([$bindTypes], $bindParams);
    
    // Bind the parameters dynamically
    if (!call_user_func_array([$stmt, 'bind_param'], $bindParamsRefs)) {
        echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        exit;
    }

    // Execute the statement
    if (!$stmt->execute()) {
        echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        exit;
    }

    // Update session variable for admin_email
    $_SESSION["admin_email"] = $email;

    // Show alert for successful update
    echo '<script>alert("Admin profile updated successfully!"); window.location.href="usermanagement.php";</script>';
    exit;
}
?>
