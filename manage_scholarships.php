<?php
session_start();
include 'config/db_connect.php';

if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM scholarships WHERE scholarship_id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $_SESSION['success'] = "✅ Scholarship deleted successfully.";
    } else {
        $_SESSION['error'] = "❌ Failed to delete scholarship.";
    }
    header("Location: manage_scholarships.php");
    exit();
}

$sql = "SELECT * FROM scholarships ORDER BY deadline DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Scholarships</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #eef2f7, #f9fbfd);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .container {
            max-width: 1000px;
        }

        h2 {
            color: #0d6efd;
            font-weight: 600;
        }

        .btn {
            font-size: 0.9rem;
        }

        .btn-success {
            background-color: #198754;
        }

        .btn-success:hover {
            background-color: #157347;
        }

        .btn-warning {
            background-color: #ffc107;
            color: #212529;
        }

        .btn-warning:hover {
            background-color: #e0a800;
        }

        .btn-danger {
            background-color: #dc3545;
        }

        .btn-danger:hover {
            background-color: #bb2d3b;
        }

        .table {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.05);
        }

        thead th {
            background-color: #0d6efd;
            color: white;
            font-size: 0.85rem;
            text-align: center;
            text-transform: uppercase;
        }

        tbody td {
            text-align: center;
            vertical-align: middle;
            font-size: 0.92rem;
        }

        .table-hover tbody tr:hover {
            background-color: #f1f5ff;
        }

        .alert {
            font-size: 0.95rem;
        }

        .top-btns {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        @media (max-width: 576px) {
            .top-btns {
                flex-direction: column;
                gap: 0.5rem;
            }
        }

        .action-buttons .btn {
            margin: 0 2px;
        }

        .fade-in {
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

<div class="container mt-5 fade-in">
    <h2 class="mb-4 text-center">🎓 Manage Scholarships</h2>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success text-center"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php elseif (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger text-center"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <div class="top-btns mb-3">
        <a href="add_scholarship.php" class="btn btn-success">➕ Add Scholarship</a>
        <a href="admin_dashboard.php" class="btn btn-secondary">⬅ Back to Dashboard</a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover bg-white">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Deadline</th>
                    <th>Fund</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['scholarship_id'] ?></td>
                        <td><?= htmlspecialchars($row['title']) ?></td>
                        <td><?= htmlspecialchars($row['deadline']) ?></td>
                        <td>Rs <?= number_format($row['fund_amount'], 2) ?></td>
                        <td class="action-buttons">
                            <a href="edit_scholarship.php?id=<?= $row['scholarship_id'] ?>" class="btn btn-sm btn-warning">✏️ Edit</a>
                            <a href="manage_scholarships.php?delete=<?= $row['scholarship_id'] ?>" 
                               class="btn btn-sm btn-danger"
                               onclick="return confirm('Are you sure you want to delete this scholarship?');">🗑️ Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center text-muted">No scholarships found.</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
