<?php
session_start();

include('./config.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: ./users/login.php');
    exit;
}

if (isset($_POST['id']) && !empty($_POST['id'])) {
    $resume_id = base64_decode($_POST['id']);
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("DELETE FROM resumes WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $resume_id, $user_id);

    if ($stmt->execute()) {
        header('Location: dashboard.php?message=Resume deleted successfully');
        exit;
    } else {
        echo "Error: Could not delete the resume.";
    }
    $stmt->close();
} else {
    header('Location: dashboard.php?error=No resume ID provided');
    exit;
}
