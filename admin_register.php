

<!DOCTYPE html>
<html>
<head>
    <title>Admin Register</title>
</head>
<body>
    <h2>Admin Registration</h2>
    <form action="process/admin_register_process.php" method="POST">
        <label>Username:</label><br>
        <input type="text" name="username" required><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>

        <input type="submit" value="Register Admin">
    </form>
    <br><a href="admin_login.php">Back to Admin Login</a>
</body>
</html>
