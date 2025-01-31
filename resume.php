<?php
include('./config.php');
$id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM resumes WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$resume = $stmt->get_result()->fetch_assoc();

echo $resume['generated_resume_html']; // Assuming you stored the HTML generated resume
?>
