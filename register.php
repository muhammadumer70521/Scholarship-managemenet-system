<!-- register.php -->
<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Poppins', sans-serif;
        }
        .register-box {
            max-width: 500px;
            margin: 80px auto;
            padding: 30px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }
        h2 {
            margin-bottom: 30px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="register-box">
        <h2 class="text-center">🎓 Student Registration</h2>
        <form action="process/register_process.php" method="POST">
            <div class="mb-3">
            Profile Picture: <input type="file" name="profile_pic" accept="image/*"><br><br>
                <label class="form-label">Student ID</label>
                <input type="text" class="form-control" name="student_id" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Full Name</label>
                <input type="text" class="form-control" name="name" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email address</label>
                <input type="email" class="form-control" name="email" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" class="form-control" name="password" required>
            </div>
            <div class="mb-3">
                <label class="form-label">GPA</label>
                <input type="number" step="0.01" class="form-control" name="gpa" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Financial Status</label>
                <select name="financial_status" class="form-select" required>
                    <option value="">-- Select --</option>
                    <option value="Low">Low</option>
                    <option value="Medium">Medium</option>
                    <option value="High">High</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary w-100">Register</button>
        </form>
        <p class="mt-3 text-center">Already have an account? <a href="login.php">Login here</a></p>
    </div>
</div>

</body>
</html>
