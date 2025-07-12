<?php 
 session_start();
if (isset($_GET['register']) && $_GET['register'] == 'success'): ?>
    <div class="alert alert-success text-center">
        Registration successful! Please login.
    </div>
<?php endif; ?>
<?php
if (isset($_GET['redirect'])) {
    $_SESSION['redirect_after_login'] = $_GET['redirect'];
}
 ?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Poppins', sans-serif;
        }
        .login-box {
            max-width: 450px;
            margin: 100px auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        h2 {
            margin-bottom: 25px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="login-box" style="margin-top: -1px; margin-top: 50px; ">
        <h2 class="text-center">🔐 Student Login</h2>
        <form action="process/login_process.php" method="POST">
            <div class="mb-3">
                <label class="form-label">Email address</label>
                <input type="email" class="form-control" name="email" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" class="form-control" name="password" required>
            </div>
            <button type="submit" class="btn btn-success w-100">Login</button>
        </form>
        <p class="text-center mt-3">Don't have an account? <a href="register.php">Register here</a></p>
        <p class="text-center mt-3"> <a href="admin_login.php">Amin Login</a></p>

    </div>
</div>

</body>
</html>
