<?php
session_start();
include('./config.php');

$id = ($_GET['id']);

if (isset($_GET['id'])) {
    $resume_id = base64_decode($_GET['id']);
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("SELECT * FROM resumes WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $resume_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $resume = $result->fetch_assoc();

    $templateType = $resume['template_type'];

    header('location: ./template/' . $templateType . '_template.php' . '?id=' . base64_encode($resume['id']));
}
