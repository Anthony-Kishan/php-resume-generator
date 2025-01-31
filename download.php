<?php
include('./config.php');

require_once 'vendor/autoload.php';  // Adjust the path if needed
use Dompdf\Dompdf;
use Dompdf\Options;
$options = new Options();
$options->set('isHtml5ParserEnabled', true);  // Enable HTML5
$options->set('isPhpEnabled', true);          // Enable PHP in the HTML


$id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM resumes WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$resume = $stmt->get_result()->fetch_assoc();

$htmlContent = $resume['generated_resume_html']; // The resume content

// Generate a PDF or allow direct download
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="resume.pdf"');

require_once 'vendor/autoload.php';  // Using a library like dompdf to convert HTML to PDF
$dompdf = new Dompdf($options);
$dompdf->loadHtml($htmlContent);
$dompdf->render();
$dompdf->stream('resume.pdf');
exit;
?>