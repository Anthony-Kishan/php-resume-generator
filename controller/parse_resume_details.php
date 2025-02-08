<?php

$queryShow = $conn->prepare("SELECT * FROM resumes WHERE `user_id` = $userId");
$queryShow->execute();
$result = $queryShow->get_result();
$resume = $result->fetch_assoc();

$personal_info = json_decode($resume['personal_info'], true);
$education = json_decode($resume['education'], true);
$experience = json_decode($resume['experience'], true);
$skills = json_decode($resume['skills'], true);


// SEPARATE FIRSTNAME AND LASTNAME
$fullName = htmlspecialchars($personal_info["fullName"]);
$nameParts = explode(" ", $fullName);

if (count($nameParts) > 1) {
    $firstName = $nameParts[0];
    $lastName = $nameParts[count($nameParts) - 1];
} else {
    $firstName = $nameParts[0];
    $lastName = '';
}


// EDUCATION SECTION
$eduList = '';
foreach ($education as $edu) {
    $endDate = DateTime::createFromFormat('Y-m', $edu['endDate']);
    $endFormatted = $endDate->format('M Y');
    $EduformattedDateRange = strtoupper($endFormatted);

    $eduBlock = "
<div class='education'>
    <h5 class='text-uppercase fw-bold'>" . $edu['institution'] . "</h5>
    <h5 class='text-uppercase fw-lighter'>" . $edu['degree'] . "</h5>
    <p>Grad." . $EduformattedDateRange . "</p>
</div>";

    $eduList .= $eduBlock;
}

// EXPERIENCE SECTION
$expList = '';
foreach ($experience as $exp) {
    $startDate = DateTime::createFromFormat('Y-m', $exp['startDate']);
    $endDate = DateTime::createFromFormat('Y-m', $exp['endDate']);
    $startFormatted = $startDate->format('M Y'); // E.g., "June 2024"

    if (!empty($exp['endDate'])) {
        $endFormatted = $endDate->format('M Y'); // E.g., "Aug 2024"
    } else {
        $endFormatted = "Present";
    }
    $ExpformattedDateRange = strtoupper($startFormatted) . ' - ' . strtoupper($endFormatted);

    $expBlock = "
<div class='experience mb-3'>
    <h5 class='text-uppercase fw-bold'>" . $exp['jobTitle'] . " | <span class='fs-6'>" . $ExpformattedDateRange . "</span></h5>
    <h5 class='text-capitalize'>" . $exp['company'] . "</h5>
    <li class='ms-4'>" . $exp['responsibilities'] . "</li>
</div>";

    $expList .= $expBlock;
}

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
