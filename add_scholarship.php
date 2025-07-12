<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Scholarship</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f7fc;
            font-family: 'Poppins', sans-serif;
        }

        h3 {
            color: #2c3e50;
            font-weight: 600;
        }

        label {
            font-weight: 500;
        }

        .form-control {
            font-size: 0.95rem;
        }

        .btn-success {
            background-color: #198754;
            padding: 0.5rem 1.25rem;
        }

        .btn-success:hover {
            background-color: #157347;
        }

        .btn-outline-secondary {
            padding: 0.5rem 1rem;
        }

        .container {
            max-width: 700px;
        }

        .form-box {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 18px rgba(0, 0, 0, 0.05);
        }

        .btn-group {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        @media (max-width: 576px) {
            .btn-group {
                flex-direction: column;
                align-items: stretch;
            }
        }
    </style>
</head>
<body>

<div class="container my-5">
    <h3 class="mb-4 text-center">📚 Add New Scholarship</h3>

    <form action="process/add_scholarship_process.php" method="POST" class="form-box">
        <div class="mb-3">
            <label for="title" class="form-label">Scholarship Title</label>
            <input type="text" name="title" class="form-control" placeholder="e.g., Merit-Based Scholarship" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="3" placeholder="Brief details about the scholarship..." required></textarea>
        </div>

        <div class="mb-3">
            <label for="eligibility_criteria" class="form-label">Eligibility Criteria</label>
            <textarea name="eligibility_criteria" class="form-control" rows="3" placeholder="Who can apply?" required></textarea>
        </div>

        <div class="mb-3">
            <label for="deadline" class="form-label">Application Deadline</label>
            <input type="date" name="deadline" class="form-control" required>
        </div>

        <div class="mb-4">
            <label for="fund_amount" class="form-label">Fund Amount (in PKR)</label>
            <input type="number" name="fund_amount" class="form-control" step="0.01" placeholder="e.g., 50000" required>
        </div>

        <div class="btn-group">
            <button type="submit" class="btn btn-success">✅ Add Scholarship</button>
            <a href="admin_dashboard.php" class="btn btn-outline-secondary">← Back to Dashboard</a>
        </div>
    </form>
</div>

</body>
</html>
