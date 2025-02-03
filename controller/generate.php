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


$stmt = $conn->prepare("INSERT INTO resumes (user_id, template_type, personal_info, education, experience, skills) VALUES (?, ?, ?, ?, ?, ?)");

$templateType = $data['template'];
$personalInfo = json_encode($data['personalInfo']);
$education = json_encode($data['education']);
$experience = json_encode($data['experience']);
$skills = json_encode($data['skills']);

$stmt->bind_param("isssss", $userId, $templateType, $personalInfo, $education, $experience, $skills);
$stmt->execute();

echo $html = file_get_contents("template/modern_template.php");

// echo json_encode([
//     'success' => true,
//     'resume' => $generatedResume
// ]);

echo $html =
    '<div id="htmlPreviewContainer">
    <iframe src="./template/modern_template.php"></iframe>
    <?php
    // Include the contents of the HTML file
    include("template/modern_template.php");
    ?>
</div>';
