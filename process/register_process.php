<?php

include '../config/db_connect.php';

$profile_pic = null;
if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] === 0) {
    $target_dir = "../uploads/";
    $file_name = uniqid() . "_" . basename($_FILES["profile_pic"]["name"]);
    $target_file = $target_dir . $file_name;
    move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $target_file);
    $profile_pic = $file_name;
}

$student_id = $_POST['student_id'];
$name = $_POST['name'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$gpa = $_POST['gpa'];
$financial_status = $_POST['financial_status'];

$sql = "INSERT INTO students (student_id, name, email, password, gpa, financial_status)
        VALUES (?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssds", $student_id, $name, $email, $password, $gpa, $financial_status);

if ($stmt->execute()) {

    header("Location: ../login.php?register=success");
    exit();
} else {
    echo "Error: " . $stmt->error;
}

$conn->close();
?>
