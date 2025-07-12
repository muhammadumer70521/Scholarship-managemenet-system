<?php
// 
session_start();
include '../config/db_connect.php';

if (!isset($_SESSION['student_id'])) {
    header("Location: ../login.php");
    exit();
}

$student_id = $_SESSION['student_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['scholarship_id'])) {
    $scholarship_id = $_POST['scholarship_id'];

    if ($res->num_rows > 0) {
        header("Location: ../student_dashboard.php?applied=duplicate");
        exit();
    }

    $stmt = $conn->prepare("INSERT INTO applications (student_id, scholarship_id, status, submission_date, review_notes) VALUES (?, ?, 'Pending', NOW(), '')");
    $stmt->bind_param("ii", $student_id, $scholarship_id);

    if ($stmt->execute()) {
        header("Location: ../student_dashboard.php?applied=true");
    } else {
        header("Location: ../student_dashboard.php?applied=error");
    }

    exit();
}
?>
