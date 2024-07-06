<?php
session_start();
require "../dbconnect.php";

// Function to update user image
function updateUserImage($userImg) {
    $errors = [];
    $uploadedFileName = "";

    // Check if a new image file is uploaded
    if ($userImg['error'] == 0) {
        $allowedTypes = ['image/jpeg', 'image/png'];
        $fileType = mime_content_type($userImg['tmp_name']);
        if (!in_array($fileType, $allowedTypes)) {
            $errors[] = "Only JPG and PNG files are allowed.";
        } else {
            $extension = pathinfo($userImg['name'], PATHINFO_EXTENSION);
            $uploadedFileName = uniqid() . '.' . $extension;
            $uploadDir = '../images/profile_img/';
            $uploadFilePath = $uploadDir . $uploadedFileName;
            if (!move_uploaded_file($userImg['tmp_name'], $uploadFilePath)) {
                $errors[] = "Failed to upload image.";
            }
        }
    }

    // Return uploaded file name if successfully uploaded
    return $uploadedFileName ?: null;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $studentNum = $_POST['student_num'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $userName = $_POST['student_name'];
    $phonNum = $_POST['phonum'];
    $userImg = $_FILES['profileimg'];

    // Fetch the user_id from POST
    $user_id = $_POST['user_id'];

    // Update user image if provided
    $uploadedFileName = updateUserImage($userImg);

    // Prepare the SQL statement
    $sql = "UPDATE user SET 
                user_email = ?, 
                student_num = ?, 
                user_name = ?, 
                user_phonum = ?";

    // Hash the password if it's not empty
    if (!empty($password)) {
        $hashedPass = password_hash($password, PASSWORD_DEFAULT);
        $sql .= ", user_pass = ?";
    } else {
        $hashedPass = null; // Ensure no password update if empty
    }

    // Append user image update if provided
    if ($uploadedFileName !== null) {
        $sql .= ", user_img = ?";
    }

    $sql .= " WHERE user_id = ?";

    // Prepare the statement
    $stmt = $connect->prepare($sql);

    if (!$stmt) {
        echo "Prepare failed: (" . $connect->errno . ") " . $connect->error;
        exit;
    }

    // Bind parameters
    $bindParams = [$email, $studentNum, $userName, $phonNum];

    // Bind password parameter if updated
    if (!empty($password)) {
        $bindParams[] = $hashedPass;
    }

    // Bind image parameter if updated
    if ($uploadedFileName !== null) {
        $bindParams[] = $uploadedFileName;
    }

    // Add user_id as the last parameter
    $bindParams[] = $user_id;

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

    // Update session variable for user_email
    $_SESSION["user_email"] = $email;

    // Show alert for successful update
    echo '<script>alert("Profile updated successfully!"); window.location.href="usermanagement.php";</script>';
    exit;
}
?>
