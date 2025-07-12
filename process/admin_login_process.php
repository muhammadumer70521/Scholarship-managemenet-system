<?php
session_start();
include '../config/db_connect.php';

$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT * FROM admins WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($row && password_verify($password, $row['password'])) {
    $_SESSION['admin'] = $username;
    header("Location: ../admin_dashboard.php");
} else {
    echo "Invalid login.<br><a href='../admin_login.php'>Back</a>";
}
?>
