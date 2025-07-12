<?php
session_start();
include 'config/db_connect.php';

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['scholarship_id'])) {
    $scholarship_id = $_POST['scholarship_id'];

    $delete_apps = $conn->prepare("DELETE FROM applications WHERE scholarship_id = ?");
    $delete_apps->bind_param("i", $scholarship_id);
    $delete_apps->execute();

    //  ----------- Delete scholarship  -----------
    $stmt = $conn->prepare("DELETE FROM scholarships WHERE scholarship_id = ?");
    $stmt->bind_param("i", $scholarship_id);

    if ($stmt->execute()) {
        header("Location: delete_scholarship.php?status=deleted");
        exit();
    } else {
        header("Location: delete_scholarship.php?status=error");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Delete Scholarships</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h2 class="mb-4 text-danger">🗑 Delete Scholarships</h2>

    <?php if (isset($_GET['status'])): ?>
        <div class="alert 
            <?= $_GET['status'] === 'deleted' ? 'alert-success' : 'alert-danger' ?>">
            <?= $_GET['status'] === 'deleted' ? '✅ Scholarship deleted successfully.' : '❌ Deletion failed.' ?>
        </div>
    <?php endif; ?>

    <table class="table table-bordered table-striped">
        <thead class="table-danger">
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Deadline</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $sql = "SELECT scholarship_id, title, description, deadline FROM scholarships ORDER BY deadline DESC";
        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()):
        ?>
            <tr>
                <td><?= htmlspecialchars($row['title']) ?></td>
                <td><?= htmlspecialchars($row['description']) ?></td>
                <td><?= htmlspecialchars($row['deadline']) ?></td>
                <td>
                    <form method="POST" action="delete_scholarship.php" onsubmit="return confirm('Delete this scholarship?');">
                        <input type="hidden" name="scholarship_id" value="<?= $row['scholarship_id'] ?>">
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>

    <a href="admin_dashboard.php" class="btn btn-secondary mt-3">⬅ Back to Dashboard</a>
</div>

</body>
</html>
