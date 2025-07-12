<?php
session_start();
include '../config/db_connect.php';

if (!isset($_SESSION['admin'])) {
    header("Location: ../admin_login.php");
    exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $eligibility = $_POST['eligibility_criteria'];
    $deadline = $_POST['deadline'];
    $fund_amount = $_POST['fund_amount'];

    $stmt = $conn->prepare("INSERT INTO scholarships (title, description, eligibility_criteria, deadline, fund_amount) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssd", $title, $description, $eligibility, $deadline, $fund_amount);

    if ($stmt->execute()) {
        header("Location: ../admin_dashboard.php?added=success");
        exit();
    } else {
        echo "Error adding scholarship: " . $stmt->error;
    }
}
?>
