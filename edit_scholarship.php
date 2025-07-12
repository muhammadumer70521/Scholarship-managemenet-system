<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include 'config/db_connect.php';

if (!isset($_SESSION['admin'])) {
    header('Location: admin_login.php');
    exit();
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['error'] = "No scholarship selected";
    header('Location: manage_scholarships.php');
    exit();
}

$scholarship_id = intval($_GET['id']);

$sql = "SELECT * FROM scholarships WHERE scholarship_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $scholarship_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $scholarship = $result->fetch_assoc();
} else {
    $_SESSION['error'] = "Scholarship not found";
    header('Location: manage_scholarships.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $eligibility_criteria = trim($_POST['eligibility_criteria']);
    $deadline = trim($_POST['deadline']);
    $fund_amount = trim($_POST['fund_amount']);

    if (empty($title) || empty($description) || empty($eligibility_criteria) || empty($deadline) || empty($fund_amount)) {
        $_SESSION['error'] = "All fields are required";
    } else {
        $update = $conn->prepare("UPDATE scholarships 
                                  SET title=?, description=?, eligibility_criteria=?, deadline=?, fund_amount=?
                                  WHERE scholarship_id=?");
        $update->bind_param("ssssdi", $title, $description, $eligibility_criteria, $deadline, $fund_amount, $scholarship_id);

        if ($update->execute()) {
            $_SESSION['success'] = "✅ Scholarship updated successfully.";
            header("Location: manage_scholarships.php");
            exit();
        } else {
            $_SESSION['error'] = "❌ Error updating scholarship: " . $conn->error;
        }
    }

    $scholarship['title'] = $title;
    $scholarship['description'] = $description;
    $scholarship['eligibility_criteria'] = $eligibility_criteria;
    $scholarship['deadline'] = $deadline;
    $scholarship['fund_amount'] = $fund_amount;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Scholarship</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f7fc;
            font-family: 'Poppins', sans-serif;
        }
        .container {
            max-width: 720px;
        }
        h2 {
            color: #2c3e50;
            font-weight: 600;
        }
        .form-box {
            background-color: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.06);
        }
        .form-label {
            font-weight: 500;
        }
        .btn-success {
            padding: 0.5rem 1.25rem;
        }
        .btn-secondary {
            padding: 0.5rem 1.25rem;
        }
    </style>
</head>
<body>

<div class="container my-5">
    <h2 class="mb-4 text-center">✏️ Edit Scholarship</h2>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <form method="POST" class="form-box">
        <div class="mb-3">
            <label class="form-label">Scholarship Title</label>
            <input type="text" name="title" class="form-control" 
                   value="<?= htmlspecialchars($scholarship['title'] ?? '') ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="4" required><?= 
                htmlspecialchars($scholarship['description'] ?? '') ?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Eligibility Criteria</label>
            <textarea name="eligibility_criteria" class="form-control" rows="4" required><?= 
                htmlspecialchars($scholarship['eligibility_criteria'] ?? '') ?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Application Deadline</label>
            <input type="date" name="deadline" class="form-control" 
                   value="<?= htmlspecialchars($scholarship['deadline'] ?? '') ?>" required>
        </div>

        <div class="mb-4">
            <label class="form-label">Fund Amount (PKR)</label>
            <input type="number" name="fund_amount" step="0.01" class="form-control" 
                   value="<?= htmlspecialchars($scholarship['fund_amount'] ?? '') ?>" required>
        </div>

        <div class="d-flex justify-content-between">
            <a href="manage_scholarships.php" class="btn btn-secondary">← Cancel</a>
            <button type="submit" class="btn btn-success">💾 Save Changes</button>
        </div>
    </form>
</div>

</body>
</html>
