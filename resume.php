<?php
session_start();
include('./config.php');

$id = $_GET['id'];

if (isset($_GET['id'])) {
    $resume_id = $_GET['id'];
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("SELECT * FROM resumes WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $resume_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $resume = $result->fetch_assoc();

    $personal_info = json_decode($resume['personal_info'], true);
    $education = json_decode($resume['education'], true);
    $experience = json_decode($resume['experience'], true);
    $skills = json_decode($resume['skills'], true);

    $template = file_get_contents('./template/modern_template.php');

    $template = str_replace('{{fullName}}', $personal_info['fullName'], $template);
    $template = str_replace('{{email}}', $personal_info['email'], $template);
    $template = str_replace('{{phone}}', $personal_info['phone'], $template);
    $template = str_replace('{{location}}', $personal_info['location'], $template);
    $template = str_replace('{{summary}}', $personal_info['summary'], $template);



    // EDUCATION SECTION
    $eduList = "";
    foreach ($education as $edu) {
        $endDate = DateTime::createFromFormat('Y-m', $edu['endDate']);
        $endFormatted = $endDate->format('M Y');
        $EduformattedDateRange = strtoupper($endFormatted);

        if (!empty($edu['endDate'])) {
            $template = str_replace('{{endDate}}', $edu['endDate'], $template);
            $template = str_replace('{{EduformattedDateRange}}', $EduformattedDateRange, $template);
        } else {
            $template = str_replace('{{endDate}}', "Expected", $template);
        }
        $template = str_replace('{{institution}}', $edu['institution'], $template);
        $template = str_replace('{{degree}}', $edu['degree'], $template);
        $template = str_replace('{{startDate}}', $edu['startDate'], $template);
    }


    // EXPERIENCE SECTION
    $expList = "";
    foreach ($experience as $exp) {
        $startDate = DateTime::createFromFormat('Y-m', $exp['startDate']);
        $endDate = DateTime::createFromFormat('Y-m', $exp['endDate']);
        $startFormatted = $startDate->format('M Y');  // E.g., "June 2024"
        $endFormatted = $endDate->format('M Y');     // E.g., "Aug 2024"
        $ExpformattedDateRange = strtoupper($startFormatted) . ' - ' . strtoupper($endFormatted);

        if ($exp['endDate'] == '') {
            $exp['endDate'] = "Present";
        }
        // $totalMonths = (int) $exp['endDate'] - (int) $exp['endDate'];
        // <li>{$totalMonths}</li>

        $template = str_replace('{{jobTitle}}', $exp['jobTitle'], $template);
        $template = str_replace('{{company}}', $exp['company'], $template);
        $template = str_replace('{{responsibilities}}', $exp['responsibilities'], $template);
        $template = str_replace('{{startDate}}', $exp['startDate'], $template);
        $template = str_replace('{{endDate}}', $exp['endDate'], $template);
        $template = str_replace('{{ExpformattedDateRange}}', $ExpformattedDateRange, $template);

    }


    $template = str_replace('{{skills}}', $skills['skills'], $template);
    $template = str_replace('{{languages}}', $skills['languages'], $template);
    $template = str_replace('{{certifications}}', $skills['certifications'], $template);

    echo $template;
}
