<?php
session_start();
include 'config/db_connect.php';


$result = $conn->query("SELECT * FROM contact_messages ORDER BY submitted_at DESC");

if (!$result) {
    die("Query failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - Contact Messages</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>📨 Contact Messages</h2>
    <table class="table table-bordered mt-4">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Message</th>
                <th>Received</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td><?= nl2br(htmlspecialchars($row['message'])) ?></td>
                        <td><?= date('Y-m-d H:i:s', strtotime($row['submitted_at'])) ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="5">No messages available</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
    <a class="btn btn-secondary" href="admin_dashboard.php">Back to Dashboard</a>

</div>

</body>
</html>
