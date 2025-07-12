<?php
session_start();
include 'config/db_connect.php';

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

$search = $_GET['search'] ?? '';

$sql = "SELECT 
            d.document_id, 
            d.type, 
            d.file_path, 
            s.name AS student_name, 
            sc.title AS scholarship_title 
        FROM documents d
        JOIN applications a ON d.application_id = a.application_id
        JOIN students s ON a.student_id = s.student_id
        JOIN scholarships sc ON a.scholarship_id = sc.scholarship_id
        WHERE s.name LIKE ?
        ORDER BY d.document_id DESC";

$stmt = $conn->prepare($sql);
$like_search = "%$search%";
$stmt->bind_param("s", $like_search);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Uploaded Documents</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Segoe UI', sans-serif;
        }
        .container {
            max-width: 1100px;
        }
        .header {
            margin-top: 40px;
            margin-bottom: 20px;
        }
        .table th, .table td {
            vertical-align: middle;
        }
        .table thead th {
            background-color: #0d6efd;
            color: #fff;
        }
        .btn-info {
            background-color: black;
            color: white;
            border: none;
        }
        .btn-info:hover {
            background-color: #138496;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header d-flex justify-content-between align-items-center">
        <h2>📁 Uploaded Documents</h2>
        <a class="btn btn-outline-secondary" href="admin_dashboard.php">← Back to Dashboard</a>
    </div>

    <!-- Search Bar -->
    <form method="GET" action="" class="input-group mb-4">
        <input type="text" name="search" class="form-control" placeholder="🔍 Search by Student Name" value="<?= htmlspecialchars($search); ?>">
        <button type="submit" class="btn btn-primary">Search</button>
    </form>

    <!-- Documents Table -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead>
                <tr>
                    <th>Student</th>
                    <th>Scholarship</th>
                    <th>Document Type</th>
                    <th>Preview</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['student_name']); ?></td>
                            <td><?= htmlspecialchars($row['scholarship_title']); ?></td>
                            <td><?= htmlspecialchars($row['type']); ?></td>
                            <td>
                                <a class="btn btn-sm btn-info" target="_blank" href="scholarship/<?= $row['file_path']; ?>">Preview</a>
                            </td>
                            <td>
                                <form method="POST" action="delete_document.php" onsubmit="return confirm('Are you sure you want to delete this document?');">
                                    <input type="hidden" name="document_id" value="<?= $row['document_id']; ?>">
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="5" class="text-center text-muted">No documents found for the current search.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
