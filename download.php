<?php
session_start();
include('./config.php');
require_once 'vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isPhpEnabled', true);
$options->set('defaultFont', 'Helvetica');

$id = $_GET['id'];

if (isset($_GET['id'])) {
    $resume_id = $_GET['id'];
    $user_id = $_SESSION['user_id']; // Logged-in user's ID

    // Fetch resume details
    $stmt = $conn->prepare("SELECT * FROM resumes WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $resume_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $resume = $result->fetch_assoc();

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


    $personal_info = json_decode($resume['personal_info'], true);
    // echo htmlspecialchars($personal_info['fullName']);


    // Generate PDF
    $dompdf = new Dompdf($options);
    $dompdf->loadHtml($template);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    $dompdf->stream($personal_info['fullName'] . '-resume', ["Attachment" => true]); // Download PDF

    exit;
}
