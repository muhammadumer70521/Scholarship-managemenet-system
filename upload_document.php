<?php
session_start();
include 'config/db_connect.php';

if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit();
}

$student_id = $_SESSION['student_id'];

$sql = "SELECT a.application_id, s.title 
        FROM applications a 
        JOIN scholarships s ON a.scholarship_id = s.scholarship_id 
        WHERE a.student_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $student_id);
$stmt->execute();
$result = $stmt->get_result();

$status = $_GET['status'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upload Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --bg-color: #f8f9fa;
            --text-color: #212529;
            --card-bg: #ffffff;
        }
        body.dark {
            --bg-color: #121212;
            --text-color: #f1f1f1;
            --card-bg: #1e1e1e;
        }
        body {
            background: var(--bg-color);
            color: var(--text-color);
            font-family: 'Segoe UI', sans-serif;
        }
        .upload-card {
            background-color: var(--card-bg);
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
            padding: 30px;
            border-radius: 15px;
            max-width: 600px;
            margin: 80px auto;
        }
        .form-label {
            font-weight: 500;
        }
        .dark-mode-toggle {
            position: fixed;
            top: 15px;
            right: 20px;
            z-index: 999;
        }
        .back-link {
            display: block;
            margin-top: 20px;
            text-align: center;
        }
        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="dark-mode-toggle">
    <button class="btn btn-sm btn-outline-secondary" onclick="toggleDarkMode()">🌙 Toggle Dark Mode</button>
</div>

<div class="container">
    <div class="upload-card">
        <h3 class="text-center mb-4">📤 Upload Document</h3>

        <?php if ($result->num_rows === 0): ?>
            <div class="alert alert-warning">No applications found for this student.</div>
        <?php else: ?>
            <form action="process/upload_process.php" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label">Select Application:</label>
                    <select name="application_id" class="form-select" required>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <option value="<?= $row['application_id']; ?>"><?= htmlspecialchars($row['title']); ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Document Type:</label>
                    <input type="text" name="type" class="form-control" placeholder="e.g. Transcript" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Upload File:</label>
                    <input type="file" name="file" class="form-control" required>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Upload</button>
                </div>
            </form>
            <a href="student_dashboard.php" class="back-link text-secondary">&larr; Back to Dashboard</a>
        <?php endif; ?>
    </div>
</div>

<!-- Toast Notification -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1050;">
    <div id="toast" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body" id="toastMessage">Success</div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    //   -----------Toast Message Logic  -----------
    const status = new URLSearchParams(window.location.search).get('status');
    const toast = document.getElementById('toast');
    const message = document.getElementById('toastMessage');

    if (status) {
        if (status === 'success') {
            toast.classList.replace('bg-danger', 'bg-success');
            message.textContent = '✅ Document uploaded successfully!';
        } else if (status === 'fail') {
            toast.classList.replace('bg-success', 'bg-danger');
            message.textContent = '❌ Failed to upload document.';
        }
        new bootstrap.Toast(toast).show();
    }

    function toggleDarkMode() {
        document.body.classList.toggle('dark');
        localStorage.setItem('darkMode', document.body.classList.contains('dark'));
    }

   
    window.onload = () => {
        if (localStorage.getItem('darkMode') === 'true') {
            document.body.classList.add('dark');
        }
    };
</script>
</body>
</html>
