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

    $templateType = $resume['template_type'];

    $personal_info = json_decode($resume['personal_info'], true);
    $education = json_decode($resume['education'], true);
    $experience = json_decode($resume['experience'], true);
    $skills = json_decode($resume['skills'], true);

    if ($templateType == 'modern') {
        $template = file_get_contents('./template/modern_template.php');
    } elseif ($templateType == 'creative') {
        $template = file_get_contents('./template/creative_template.php');
    } elseif ($templateType == 'classic') {
        $template = file_get_contents('./template/classic_template.php');
    }

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

    if ($templateType == 'modern') {
        // SKILLS SECTION
        $skillsList = '';
        foreach ($skills as $skill) {
            $skillBlock = '<div class="skill">
                        <h5 class="text-uppercase fw-bold">' . htmlspecialchars($skill['skills']) . '</h5>
                        <h5 class="text-muted">Categories:</h5>
                        <p>' . htmlspecialchars($skill['categories']) . '</p>
                    </div>';

            $skillsList .= $skillBlock;
        }
        $template = str_replace('{{skillBlock}}', $skillsList, $template);
    }



    // $template = str_replace('{{languages}}', $skills['languages'], $template);
    // $template = str_replace('{{certifications}}', $skills['certifications'], $template);

    echo $template;
}
