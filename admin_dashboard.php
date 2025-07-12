<?php
session_start();
include 'config/db_connect.php';

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f9fbfd;
            font-family: 'Poppins', sans-serif;
        }

        .navbar {
            background-color: #0d6efd;
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: 600;
        }

        .nav-link {
            color: white !important;
            font-weight: 500;
        }

        .logout-btn {
            margin-left: 20px;
        }

        .dashboard-buttons {
            margin-top: 60px;
        }

        .card {
            border: none;
            border-radius: 15px;
            background: #ffffff;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-7px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.12);
        }

        .card h4 {
            margin-top: 10px;
            color: #0d6efd;
        }

        footer {
            text-align: center;
            margin-top: 80px;
            color: #999;
            font-size: 14px;
        }
    </style>
</head>
<body>
<?php if (isset($_GET['status'])): ?>
    <div class="container mt-4">
        <div class="alert 
            <?= $_GET['status'] === 'deleted' ? 'alert-success' : 
                ($_GET['status'] === 'linked' ? 'alert-warning' : 'alert-danger') ?>">
            <?= $_GET['status'] === 'deleted' ? '✅ Scholarship deleted successfully.' : 
                ($_GET['status'] === 'linked' ? '⚠️ Cannot delete — applications are linked.' : '❌ Deletion failed.') ?>
        </div>
    </div>
<?php endif; ?>

<nav class="navbar navbar-expand-lg navbar-dark px-4 sticky-top">
    <a class="navbar-brand" href="admin_dashboard.php"><i class="fas fa-graduation-cap"></i> Scholarship Admin</a>
    <div class="ms-auto d-flex align-items-center">
        <a href="add_scholarship.php" class="nav-link" style="margin-right: 30px ;">➕ Add Scholarship</a>
        <a href="view_applications.php" class="nav-link" style="margin-right: 30px ;">📋 Applications</a>
        <a href="view_documents.php" class="nav-link" style="margin-right: 30px ;">📎 Documents</a>
        <a href="admin_messages.php" class="nav-link" style="margin-right: 30px ;">📨 Messages</a>
        <a href="logout.php" class="btn btn-outline-light logout-btn">Logout</a>
    </div>
</nav>

<div class="container dashboard-buttons text-center">
    <h2 class="mt-5 mb-4 fw-bold text-primary">Welcome to the Admin Dashboard</h2>
    <div class="row g-4 justify-content-center">

        <div class="col-md-3">
            <a href="manage_scholarships.php" class="text-decoration-none">
                <div class="card p-4">
                    <i class="fas fa-plus fa-2x text-primary"></i>
                    <h4>Manage Scholarships</h4>
                </div>
            </a>
        </div>

    

       
        <div class="col-md-3">
            <a href="view_applications.php" class="text-decoration-none">
                <div class="card p-4">
                    <i class="fas fa-clipboard-list fa-2x text-primary"></i>
                    <h4>Manage Applications</h4>
                </div>
            </a>
        </div>

        <div class="col-md-3">
            <a href="view_documents.php" class="text-decoration-none">
                <div class="card p-4">
                    <i class="fas fa-file-alt fa-2x text-primary"></i>
                    <h4>Manage Documents</h4>
                </div>
            </a>
        </div>

        <div class="col-md-3">
            <a href="admin_messages.php" class="text-decoration-none">
                <div class="card p-4">
                    <i class="fas fa-envelope-open-text fa-2x text-primary"></i>
                    <h4>View <br>Messages</h4>
                </div>
            </a>
        </div>

    </div>
</div>


<footer class="mt-5">
    &copy; <?= date('Y') ?> Scholarship Management System | Admin Panel
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
