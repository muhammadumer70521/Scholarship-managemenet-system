<?php
session_start();
include '../config/db_connect.php';

if (!isset($_SESSION['student_id'])) {
    header("Location: ../login.php");
    exit();
}

$application_id = $_POST['application_id'];
$type = $_POST['type'];

//   -----------Upload directory  -----------
$target_dir = "../uploads/";
$filename = uniqid() . "_" . basename($_FILES["file"]["name"]);
$target_file = $target_dir . $filename;
$relative_path = "uploads/" . $filename;


if (!file_exists($target_dir)) {
    mkdir($target_dir, 0777, true);
}
if (!is_writable($target_dir)) {
    die("Upload folder not writable");
}

if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
    $stmt = $conn->prepare("INSERT INTO documents (application_id, type, file_path) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $application_id, $type, $relative_path);
    
    if ($stmt->execute()) {
        header("Location: ../student_dashboard.php?upload=success");
        exit();
    } else {
        header("Location: ../student_dashboard.php?upload=fail");
        exit();
    }
} 

?>
