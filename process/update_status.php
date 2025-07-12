<?php
session_start();
include '../config/db_connect.php';

if (!isset($_SESSION['admin'])) {
    header("Location: ../admin_login.php");
    exit();
}

$application_id = $_POST['application_id'];
$status = $_POST['status'];

$sql = "UPDATE applications SET status = ? WHERE application_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $status, $application_id);

if ($stmt->execute()) {
    echo "<script>
            alert('Application status updated successfully.');
            window.location.href = '../view_applications.php';  // Stay on the admin dashboard page
          </script>";
} else {
    echo "Error: " . $stmt->error;
}

$conn->close();
?>
