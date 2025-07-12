<?php

session_start();
include 'config/db_connect.php';

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);

    $check = $conn->prepare("SELECT * FROM applications WHERE application_id = ?");
    $check->bind_param("i", $delete_id);
    $check->execute();
    $result_check = $check->get_result();

    if ($result_check->num_rows === 1) {
        $delete = $conn->prepare("DELETE FROM applications WHERE application_id = ?");
        $delete->bind_param("i", $delete_id);
        if ($delete->execute()) {
            $_SESSION['success'] = "✅ Application deleted successfully.";
        } else {
            $_SESSION['error'] = "❌ Error deleting application.";
        }
    } else {
        $_SESSION['error'] = "❌ Application not found.";
    }
    header("Location: view_applications.php");
    exit();
}

$sql = "SELECT a.application_id, a.status, a.submission_date AS applied_at,
               s.title AS scholarship_title, s.deadline,
               u.name AS student_name, u.email
        FROM applications a
        JOIN scholarships s ON a.scholarship_id = s.scholarship_id
        JOIN students u ON a.student_id = u.student_id
        ORDER BY a.submission_date DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Scholarship Applications</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    body {
        background-color: #f2f4f8;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: #333;
    }

    .navbar {
        background-color: #0d6efd;
        padding: 0.8rem 1rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .navbar a.navbar-brand {
        font-weight: bold;
        font-size: 1.4rem;
        color: #fff;
    }

    .logout-btn {
        position: absolute;
        top: 15px;
        right: 20px;
    }

    .container {
        margin-top: 50px;
    }

    h2 {
        color: #2c3e50;
        margin-bottom: 20px;
    }

    .alert {
        font-size: 0.95rem;
    }

    .table {
        background-color: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.08);
    }

    .table th {
        background-color: #0d6efd;
        color: #fff;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
        text-align: center;
    }

    .table td {
        vertical-align: middle;
        font-size: 0.9rem;
        background-color: #fdfdfd;
        text-align: center;
    }

    .table tr:nth-child(even) td {
        background-color: #f3f6fa;
    }

    .btn-sm {
        padding: 0.35rem 0.6rem;
        font-size: 0.8rem;
    }

    .btn-info {
        background-color: #17a2b8;
        border: none;
        color: #fff;
    }

    .btn-info:hover {
        background-color: #138496;
    }

    .btn-warning {
        background-color: #ffc107;
        border: none;
        color: #212529;
    }

    .btn-warning:hover {
        background-color: #e0a800;
    }

    .btn-danger {
        background-color: #dc3545;
        border: none;
        color: #fff;
    }

    .btn-danger:hover {
        background-color: #bd2130;
    }

    .form-inline {
        display: flex;
        gap: 0.4rem;
        align-items: center;
        justify-content: center;
    }

    .form-inline select {
        padding: 0.3rem 0.5rem;
        font-size: 0.8rem;
        border-radius: 4px;
        border: 1px solid #ccc;
    }

    .form-inline button {
        padding: 0.3rem 0.6rem;
        font-size: 0.8rem;
        background-color: #0d6efd;
        color: #fff;
        border: none;
        border-radius: 4px;
    }

    .form-inline button:hover {
        background-color: #0b5ed7;
    }

    @media (max-width: 768px) {
        .form-inline {
            flex-direction: column;
            gap: 0.3rem;
        }

        .logout-btn {
            position: static;
            margin-top: 10px;
        }
    }
</style>

</head>
<body>


<nav class="navbar navbar-expand-lg navbar-dark px-5">
    <a class="navbar-brand" href="admin_dashboard.php">🎓 Scholarship Admin</a>
    <div class="ml-auto">
        <a href="logout.php" class="btn btn-outline-light logout-btn">Logout</a>
    </div>
</nav>
<a href="admin_dashboard.php" class="btn btn-secondary"style="margin-left: 800px; margin-bottom: -50px;">⬅ Back to Dashboard</a>

<div class="container">
    <h2>📋 All Scholarship Applications</h2>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Student Name</th>
                <th>Email</th>
                <th>Scholarship</th>
                <th>Status</th>
                <th>Deadline</th>
                <th>Applied At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php $i = 1; while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $i++ ?></td>
                <td><?= htmlspecialchars($row['student_name']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= htmlspecialchars($row['scholarship_title']) ?></td>
                <td><?= htmlspecialchars($row['status']) ?></td>
                <td><?= $row['deadline'] ?></td>
                <td><?= $row['applied_at'] ?></td>
                <td>
                <!-- <a href="generate_pdf.php?id=<?= $row['application_id'] ?>" target="_blank" class="btn btn-info btn-sm mb-1">PDF</a> -->

                <form action="process/update_status.php" method="POST" class="form-inline mb-1">
                    <input type="hidden" name="application_id" value="<?= $row['application_id'] ?>">
                    <select name="status" required>
                        <option value="">Change status</option>
                        <option value="Approved">Approve</option>
                        <option value="Rejected">Reject</option>
                    </select>
                    <!-- <button type="submit">Update</button> -->
                </form>

                <a href="view_applications.php?delete_id=<?= $row['application_id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this application?');">Delete</a>
            </td>

            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>
<script>
    document.querySelectorAll('select[name="status"]').forEach(select => {
        select.addEventListener('change', function () {
            this.form.submit();
        });
    });
</script>
