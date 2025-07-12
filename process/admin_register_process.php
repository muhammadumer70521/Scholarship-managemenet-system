<?php
include '../config/db_connect.php';

$username = $_POST['username'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // hashed password

//    -----------Check if admin already exists------------
$check = $conn->prepare("SELECT * FROM admins WHERE username = ?");
$check->bind_param("s", $username);
$check->execute();
$result = $check->get_result();

if ($result->num_rows > 0) {
    echo "Username already exists. Try a different one.<br>";
    echo "<a href='../admin_register.php'>Back</a>";
    exit();
}

//   -----------Insert new admin  -----------
$sql = "INSERT INTO admins (username, password) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $username, $password);

if ($stmt->execute()) {
    echo "Admin registered successfully.<br>";
    echo "<a href='../admin_login.php'>Go to Admin Login</a>";
} else {
    echo "Error: " . $stmt->error;
}
?>
