<?php
session_start();
include 'config/db_connect.php';

$student_id = $_SESSION['student_id'] ?? null;
if (!$student_id) {
    header("Location: login.php");
    exit;
}

$sql_applications = "SELECT status, COUNT(*) as count FROM applications WHERE student_id = ? GROUP BY status";
$stmt2 = $conn->prepare($sql_applications);
$stmt2->bind_param("s", $student_id);
$stmt2->execute();
$result2 = $stmt2->get_result();

$statuses = ["Pending" => 0, "Approved" => 0, "Rejected" => 0];
while ($row = $result2->fetch_assoc()) {
    $statuses[$row['status']] = $row['count'];
}

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
$success = $_GET['applied'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Dashboard - Available Scholarships</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
            font-family: 'Poppins', sans-serif;
        }
        .profile-pic {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 50%;
            border: 3px solid #007bff;
        }
        .card-box:hover {
            transform: translateY(-4px);
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        .alert {
            margin-top: 15px;
        }
    </style>
</head>
<body>

<div class="container py-5">

   
    <h4 class="mb-3">📋 Available Scholarships</h4>

    <?php while ($row = $result->fetch_assoc()): ?>
        <?php
            $check_sql = "SELECT 1 FROM applications WHERE student_id = ? AND scholarship_id = ?";
            $check_stmt = $conn->prepare($check_sql);
            $check_stmt->bind_param("ss", $student_id, $row['scholarship_id']);
            $check_stmt->execute();
            $already_applied = $check_stmt->get_result()->num_rows > 0;
        ?>
        <div class="card mb-3 shadow-sm card-box">
            <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($row['title']) ?></h5>
                <p class="card-text"><strong>Description:</strong> <?= nl2br(htmlspecialchars($row['description'])) ?></p>
                <p><strong>Eligibility:</strong> <?= nl2br(htmlspecialchars($row['eligibility_criteria'])) ?></p>
                <p><strong>Deadline:</strong> <?= htmlspecialchars($row['deadline']) ?></p>
                <p><strong>Fund Amount:</strong> $<?= number_format($row['fund_amount'], 2) ?></p>

                <?php if ($already_applied): ?>
                    <button class="btn btn-secondary btn-sm" disabled>✅ Already Applied</button>
                <?php else: ?>
                    <form action="process/apply_process.php" method="POST" class="d-inline">
                        <input type="hidden" name="scholarship_id" value="<?= $row['scholarship_id'] ?>">
                        <button type="submit" class="btn btn-primary btn-sm">Apply Now</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    <?php endwhile; ?>

</div>

</body>
</html>
