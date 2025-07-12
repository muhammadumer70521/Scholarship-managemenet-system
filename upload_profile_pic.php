<?php
session_start();
include 'config/db_connect.php'; 
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['profile_pic'])) {
    // Get file details
    $file = $_FILES['profile_pic'];
    $fileName = $_FILES['profile_pic']['name'];
    $fileTmpName = $_FILES['profile_pic']['tmp_name'];
    $fileSize = $_FILES['profile_pic']['size'];
    $fileError = $_FILES['profile_pic']['error'];
    $fileType = $_FILES['profile_pic']['type'];

    // Allowed file extensions
    $allowed = array('jpg', 'jpeg', 'png', 'gif');

    // Get the file extension
    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    // Validate the file type
    if (in_array($fileExt, $allowed)) {
        if ($fileError === 0) {
            // Check file size (5MB max)
            if ($fileSize < 5000000) {
                // Create unique filename
                $fileNewName = uniqid('', true) . '.' . $fileExt;
                $fileDestination = 'uploads/profile_pics/' . $fileNewName;

                // Check if the directory exists, create if not
                if (!is_dir('uploads/profile_pics/')) {
                    mkdir('uploads/profile_pics/', 0777, true); // Create the directory with the correct permissions
                }

                // Move the file to the directory
                if (move_uploaded_file($fileTmpName, $fileDestination)) {
                    // Update the database with the new profile picture path
                    $studentId = $_SESSION['student_id']; // Assuming the student ID is stored in the session

                    // Prepare and execute the MySQL query to update the profile picture path
                    $query = "UPDATE students SET profile_pic = ? WHERE student_id = ?";
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param('si', $fileNewName, $studentId); // 'si' means string and integer types
                    $stmt->execute();

                    // Update the session with the new profile picture path
                    $_SESSION['profile_pic'] = $fileNewName;

                    // Redirect back to the dashboard page
                    header("Location: student_dashboard.php");
                    exit();
                } else {
                    echo "Error while moving the file.";
                }
            } else {
                echo "File is too large. Max size is 5MB.";
            }
        } else {
            echo "Error during file upload.";
        }
    } else {
        echo "Invalid file type. Only JPG, PNG, and GIF files are allowed.";
    }
}
?>
