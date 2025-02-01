<?php
include('./config.php');
require_once 'vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isPhpEnabled', true);
$options->set('defaultFont', 'Helvetica');

$id = $_GET['id'];

// Fetch resume data (ONLY ONCE)
$stmt = $conn->prepare("SELECT * FROM resumes WHERE user_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$resume = $stmt->get_result()->fetch_assoc();

// Decode JSON
$personal_info = json_decode($resume['personal_info'], true);
$education = json_decode($resume['education'], true);
$experience = json_decode($resume['experience'], true);
$skills = json_decode($resume['skills'], true);

// Load template
$template = file_get_contents('./template/modern_template.html');

// Replace placeholders with actual data
$template = str_replace('{{fullName}}', $personal_info['fullName'], $template);
$template = str_replace('{{email}}', $personal_info['email'], $template);
$template = str_replace('{{phone}}', $personal_info['phone'], $template);
$template = str_replace('{{location}}', $personal_info['location'], $template);
$template = str_replace('{{summary}}', $personal_info['summary'], $template);

// Convert education array to list
$eduList = "";
foreach ($education as $edu) {
    $eduList .= "<li><strong>{$edu['degree']}</strong> at {$edu['institution']}</li><p>{$edu['startDate']} to {$edu['endDate']}</p>";
}
$template = str_replace('{{education}}', $eduList, $template);

// Convert experience array to list
$expList = "";
foreach ($experience as $exp) {
    $expList .= "<li><strong>{$exp['jobTitle']}</strong> at {$exp['company']}</li>";
}
$template = str_replace('{{experience}}', $expList, $template);

$template = str_replace('{{skills}}', $skills['skills'], $template);
$template = str_replace('{{languages}}', $skills['languages'], $template);
$template = str_replace('{{certifications}}', $skills['certifications'], $template);

// Generate PDF
$dompdf = new Dompdf($options);
$dompdf->loadHtml($template);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream('resume.pdf', ["Attachment" => true]); // Download PDF

exit;
?>
