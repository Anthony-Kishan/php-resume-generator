<?php
session_start();
include '../config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized. Please log in.']);
    exit;
}

$userId = $_SESSION['user_id'];

$data = json_decode(file_get_contents('php://input'), true);

if (!$data) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid data']);
    exit;
}

function generateResume($data)
{
    // $template = $data['template'];
    // $personalInfo = $data['personalInfo'];
    // $education = $data['education'];
    // $experience = $data['experience'];
    // $skills = $data['skills'];

    // if ($template == "modern") {
    //     $html = file_get_contents('../template/modern_template.html');
    // } elseif ($template == "creative") {
    //     $html = file_get_contents('../template/creative_template.html');
    // } elseif ($template == "classic") {
    //     $html = file_get_contents('../template/classic_template.html');
    // }

    // $html = str_replace("{{fullName}}", $personalInfo['fullName'], $html);
    // $html = str_replace("{{email}}", $personalInfo['email'], $html);
    // $html = str_replace("{{phone}}", $personalInfo['phone'], $html);
    // $html = str_replace("{{location}}", $personalInfo['location'], $html);
    // $html = str_replace("{{summary}}", $personalInfo['summary'], $html);

    // // Process Education
    // $educationHtml = "";
    // foreach ($education as $edu) {
    //     $educationHtml .= "<div class='entry'>
    //         <div class='entry-title'>{$edu['degree']}</div>
    //         <div class='entry-details'>{$edu['institution']}, {$edu['startDate']} - {$edu['endDate']}</div>
    //     </div>";
    // }
    // $html = str_replace("{{education}}", $educationHtml, $html);

    // // Process Experience
    // $experienceHtml = "";
    // foreach ($experience as $exp) {
    //     $experienceHtml .= "<div class='entry'>
    //         <div class='entry-title'>{$exp['jobTitle']} at {$exp['company']}</div>
    //         <div class='entry-details'>{$exp['startDate']} - {$exp['endDate']}</div>
    //         <p>{$exp['responsibilities']}</p>
    //     </div>";
    // }
    // $html = str_replace("{{experience}}", $experienceHtml, $html);

    // // Process Skills
    // $skillsHtml = "";
    // // $skillsList = explode(',', $skills['skills']);
    // foreach ($skills as $skill) {
    //     $skillsHtml .= "<div class='entry'>
    //         <div class='entry-title'>{$skill['skills']}</div>
    //         <div class='entry-details'>{$skill['categories']}</div>
    //     </div>";
    // }
    // $html = str_replace("{{skills}}", $skillsHtml, $html);


    // if ($template == 'modern') {
    //     $skillsList = '';
    //     foreach ($skills as $skill) {
    //         $skillBlock = '<div class="skill">
    //                     <h5 class="text-uppercase fw-bold">' . htmlspecialchars($skill['skills']) . '</h5>
    //                     <h5 class="text-muted">Categories:</h5>
    //                     <p>' . htmlspecialchars($skill['categories']) . '</p>
    //                 </div>';

    //         $skillsList .= $skillBlock;
    //     }
    //     $template = str_replace('{{skillBlock}}', $skillsList, $html);
    // }




    // // Process Languages
    // if (!empty($skills['languages'])) {
    //     $html = str_replace("{{languages}}", "<div class='section'>
    //         <h2 class='section-title'>Languages</h2>
    //         <p>{$skills['languages']}</p>
    //     </div>", $html);
    // }

    // // Process Certifications
    // if (!empty($skills['certifications'])) {
    //     $html = str_replace("{{certifications}}", "<div class='section'>
    //         <h2 class='section-title'>Certifications</h2>
    //         <p>{$skills['certifications']}</p>
    //     </div>", $html);
    // }

    $html = "Resume created successfully check your dashboard";

    $html = "<iframe src='./template/modern_template.php' width='100%'' height='500px'></iframe>";

    return $html;
}

// Generate the resume HTML
$generatedResume = generateResume($data);

// Prepare the SQL query to insert the resume data into the database
$stmt = $conn->prepare("INSERT INTO resumes (user_id, template_type, personal_info, education, experience, skills) VALUES (?, ?, ?, ?, ?, ?)");

$templateType = $data['template'];
$personalInfo = json_encode($data['personalInfo']);
$education = json_encode($data['education']);
$experience = json_encode($data['experience']);
$skills = json_encode($data['skills']);

// Bind the parameters and execute the query
$stmt->bind_param("isssss", $userId, $templateType, $personalInfo, $education, $experience, $skills);
$stmt->execute();

// Return success response with the generated resume HTML
echo json_encode([
    'success' => true,
    'resume' => $generatedResume
]);
