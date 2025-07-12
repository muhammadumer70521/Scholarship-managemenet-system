<?php
session_start();
include 'config/db_connect.php';

if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit();
}

$student_id = $_SESSION['student_id'];

$sql_profile = "SELECT name, profile_pic FROM students WHERE student_id = ?";
$stmt = $conn->prepare($sql_profile);
$stmt->bind_param("s", $student_id);
$stmt->execute();
$profile = $stmt->get_result()->fetch_assoc();


$sql_applications = "SELECT status, COUNT(*) as count FROM applications WHERE student_id = ? GROUP BY status";
$stmt2 = $conn->prepare($sql_applications);
$stmt2->bind_param("s", $student_id);
$stmt2->execute();
$result2 = $stmt2->get_result();

$statuses = ["Pending" => 0, "Approved" => 0, "Rejected" => 0];
while ($row = $result2->fetch_assoc()) {
    $statuses[$row['status']] = $row['count'];
}

//   -----------Fetch submitted scholarships  -----------
$sql_summary = "SELECT a.application_id, s.title, a.status 
                FROM applications a 
                JOIN scholarships s ON a.scholarship_id = s.scholarship_id 
                WHERE a.student_id = ?";
$stmt3 = $conn->prepare($sql_summary);
$stmt3->bind_param("s", $student_id);
$stmt3->execute();
$applications = $stmt3->get_result();


$sql = "SELECT * FROM scholarships WHERE deadline >= CURDATE()";
$result = $conn->query($sql);

?>
    <?php if (isset($_GET['applied'])): ?>
        <div class="alert alert-<?= $_GET['applied'] === 'true' ? 'success' : ($_GET['applied'] === 'duplicate' ? 'warning' : 'danger') ?>">
            <?= $_GET['applied'] === 'true' ? 'You have successfully applied for the scholarship!' : ($_GET['applied'] === 'duplicate' ? 'You have already applied for this scholarship.' : 'Something went wrong. Please try again.') ?>
        </div>
    <?php endif; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
            font-family: 'Poppins', sans-serif;
        }
        .profile-section {
            background-color: #fff;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.05);
        }
        .profile-pic {
            width: 130px;
            height: 130px;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid #0d6efd;
        }
        .card-box {
            transition: all 0.3s;
            border: none;
            border-radius: 10px;
        }
        .card-box:hover {
            transform: translateY(-5px);
        }
        footer {
            background-color: #212529;
            color: white;
            padding: 15px 0;
            text-align: center;
        }
        footer i {
            margin: 0 10px;
            color: #fff;
            transition: 0.3s;
        }
        footer i:hover {
            color: #0d6efd;
        }
    </style>
</head>
<body>
<div class="container my-5">
    <div class="text-center profile-section mb-5">
        <img src="<?= isset($_SESSION['profile_pic']) ? 'uploads/profile_pics/' . $_SESSION['profile_pic'] : 'uploads/default.png' ?>" class="profile-pic mb-3" loading="lazy">
        <h2>Welcome, <?= htmlspecialchars($profile['name']) ?></h2>
        <form action="upload_profile_pic.php" method="POST" enctype="multipart/form-data" class="mt-3">
            <input type="file" name="profile_pic" class="form-control mb-2" required>
            <button type="submit" class="btn btn-primary btn-sm">Upload Profile Picture</button>
        </form>
        <a href="logout.php" class="btn btn-outline-danger btn-sm mt-3">Logout</a>
    </div>

    <div class="row text-center mb-4">
        <div class="col-md-4">
            <div class="card card-box shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-muted"><i class="fas fa-hourglass-half"></i> Pending</h5>
                    <p class="card-text fs-4 fw-bold text-warning"><?= $statuses['Pending'] ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-box shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-muted"><i class="fas fa-check-circle"></i> Approved</h5>
                    <p class="card-text fs-4 fw-bold text-success"><?= $statuses['Approved'] ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-box shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-muted"><i class="fas fa-times-circle"></i> Rejected</h5>
                    <p class="card-text fs-4 fw-bold text-danger"><?= $statuses['Rejected'] ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="mb-4">
        <a href="view_scholarship.php" class="btn btn-outline-primary me-2">📋 Available Scholarships</a>
        <a href="upload_document.php" class="btn btn-outline-secondary">📁 Upload Documents</a>
    </div>

    <h4 class="mb-3">📁 Submitted Applications</h4>
    <table class="table table-bordered bg-white shadow-sm">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Scholarship</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $applications->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['application_id'] ?></td>
                    <td><?= $row['title'] ?></td>
                    <td><?= $row['status'] ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<footer>
    <div class="container">
        <p>Connect with us:</p>
        <a href="#"><i class="fab fa-facebook-f"></i></a>
        <a href="#"><i class="fab fa-twitter"></i></a>
        <a href="#"><i class="fab fa-instagram"></i></a>
        <a href="#"><i class="fab fa-linkedin-in"></i></a>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const uploadStatus = new URLSearchParams(window.location.search).get('upload');
    if (uploadStatus) {
        const toastEl = document.getElementById('uploadToast');
        const toastMsg = document.getElementById('uploadToastMessage');
        if (uploadStatus === 'success') {
            toastEl.classList.replace('bg-danger', 'bg-success');
            toastMsg.textContent = '✅ Document uploaded successfully!';
        } else if (uploadStatus === 'fail') {
            toastEl.classList.replace('bg-success', 'bg-danger');
            toastMsg.textContent = '❌ Failed to upload document.';
        }
        new bootstrap.Toast(toastEl).show();
    }
</script>
</body>
</html>
