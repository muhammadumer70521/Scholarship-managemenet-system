<?php
include 'config/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['document_id'])) {
    $document_id = $_POST['document_id'];

    //   -----------Get file path before delete  -----------
    $stmt = $conn->prepare("SELECT file_path FROM documents WHERE document_id = ?");
    $stmt->bind_param("i", $document_id);
    $stmt->execute();
    $stmt->bind_result($file_path);
    $stmt->fetch();
    $stmt->close();

    //   -----------  Delete file from server  -----------
    $full_path = "../" . $file_path; //   -----------Adjust path if needed
    if (file_exists($full_path)) {
        unlink($full_path);
    }

    // Delete from database
    $stmt = $conn->prepare("DELETE FROM documents WHERE document_id = ?");
    $stmt->bind_param("i", $document_id);
    $stmt->execute();
    $stmt->close();
}

header("Location: view_documents.php");
exit();
