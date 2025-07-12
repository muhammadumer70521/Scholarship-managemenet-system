<?php
session_start();
include 'config/db_connect.php';

if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit();
}


if (isset($_GET['success']) && $_GET['success'] === 'applied') {
    echo '<div class="success">Application submitted successfully!</div>';
}
if (isset($_GET['error'])) {
    if ($_GET['error'] === 'already_applied') {
        echo '<div class="error">You have already applied for this scholarship.</div>';
    } elseif ($_GET['error'] === 'database') {
        echo '<div class="error">Database error occurred. Please try again.</div>';
    }
}

$sql = "SELECT * FROM scholarships WHERE deadline >= CURDATE()";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Available Scholarships</title>
    <style>
    .success {
        color: green;
        padding: 10px;
        margin: 10px 0;
        border: 1px solid green;
        background-color: #e6ffe6;
    }
    .error {
        color: red;
        padding: 10px;
        margin: 10px 0;
        border: 1px solid red;
        background-color: #ffe6e6;
    }
    </style>
</head>
<body>
    <h2>Available Scholarships</h2>
    <?php while ($row = $result->fetch_assoc()): ?>
        <div style="border:1px solid #ccc; padding:10px; margin:10px;">
            <h3><?php echo htmlspecialchars($row['title']); ?></h3>
            <p><strong>Criteria:</strong> <?php echo htmlspecialchars($row['eligibility_criteria']); ?></p>
            <p><strong>Deadline:</strong> <?php echo htmlspecialchars($row['deadline']); ?></p>
            <form action="process/apply_process.php" method="POST">
                <input type="hidden" name="scholarship_id" value="<?php echo $row['scholarship_id']; ?>">
                <input type="submit" value="Apply">
            </form>
        </div>
    <?php endwhile; ?>
</body>
</html>