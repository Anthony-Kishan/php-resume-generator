<?php
session_start();
include('./config.php');

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



    // EDUCATION SECTION
    $eduList = "";
    foreach ($education as $edu) {
        // $startDate = DateTime::createFromFormat('Y-m', $edu['startDate']);
        $endDate = DateTime::createFromFormat('Y-m', $edu['endDate']);

        // $startFormatted = $startDate->format('M Y');  // E.g., "June 2024"
        $endFormatted = $endDate->format('M Y');     // E.g., "Aug 2024"

        // $formattedDateRange = strtoupper($startFormatted) . ' - ' . strtoupper($endFormatted);
        $formattedDateRange = strtoupper($endFormatted);

        $eduList .= "
            <h5 class='text-uppercase fw-bold'>{$edu['institution']}</h5>
            <h5 class='text-uppercase fw-lighter'>{$edu['degree']}</h5>";

        // Check if the 'endDate' is not empty and add the corresponding graduation text
        if (!empty($edu['endDate'])) {
            $eduList .= "<p>Grad. {$formattedDateRange}</p>";
        } else {
            $eduList .= "<p>Expected Grad</p>";
        }
    }

    $template = str_replace('{{education}}', $eduList, $template);



    // EXPERIENCE SECTION
    $expList = "";
    foreach ($experience as $exp) {
        $startDate = DateTime::createFromFormat('Y-m', $exp['startDate']);
        $endDate = DateTime::createFromFormat('Y-m', $exp['endDate']);

        $startFormatted = $startDate->format('M Y');  // E.g., "June 2024"
        $endFormatted = $endDate->format('M Y');     // E.g., "Aug 2024"

        $formattedDateRange = strtoupper($startFormatted) . ' - ' . strtoupper($endFormatted);

        if ($exp['endDate'] == '') {
            $exp['endDate'] = "Present";
        }
        // $totalMonths = (int) $exp['endDate'] - (int) $exp['endDate'];
        // <li>{$totalMonths}</li>
        $expList .= "
        <h5 class='text-uppercase fw-bold'>{$exp['jobTitle']} | <span class='fs-6'>{$formattedDateRange}</span></h5>
        <h5 class='text-capitalize'>{$exp['company']}</h5>
        <li class='ms-4'>{$exp['responsibilities']}</li>
        ";
    }
    $template = str_replace('{{experience}}', $expList, $template);



    $template = str_replace('{{skills}}', $skills['skills'], $template);
    $template = str_replace('{{languages}}', $skills['languages'], $template);
    $template = str_replace('{{certifications}}', $skills['certifications'], $template);

    // Display in browser for preview
    echo $template;
}
