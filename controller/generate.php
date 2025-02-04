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

// Validate that the data is present
if (!$data) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid data']);
    exit;
}

// Check if the main fields (template, personalInfo, education, experience, skills) are present
$requiredFields = ['template', 'personalInfo', 'education', 'experience', 'skills'];

foreach ($requiredFields as $field) {
    if (empty($data[$field])) {
        echo json_encode([
            'success' => false,
            'message' => "Field '$field' is empty or missing."
        ]);
        exit;
    }
}

// Validate 'personalInfo' subfields
if (isset($data['personalInfo']) && is_array($data['personalInfo'])) {
    foreach ($data['personalInfo'] as $key => $value) {
        if (empty($value)) {
            echo json_encode([
                'success' => false,
                'message' => "Personal information field '$key' is empty."
            ]);
            exit;
        }
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => "Personal information is incomplete or invalid."
    ]);
    exit;
}

// Validate 'education', 'experience', 'skills' arrays
$validArrayFields = ['education', 'experience', 'skills'];

foreach ($validArrayFields as $field) {
    if (!is_array($data[$field]) || empty($data[$field])) {
        echo json_encode([
            'success' => false,
            'message' => ucfirst($field) . " field is incomplete or invalid."
        ]);
        exit;
    }
}

// Proceed with the database insertion if all fields are valid
$stmt = $conn->prepare("INSERT INTO resumes (user_id, template_type, personal_info, education, experience, skills) VALUES (?, ?, ?, ?, ?, ?)");

$templateType = $data['template'];

// Ensure no empty fields are being encoded
$personalInfo = json_encode(array_filter($data['personalInfo'], fn($value) => !empty($value)));  // Remove empty fields
$education = json_encode(array_filter($data['education'], fn($value) => !empty($value)));  // Remove empty fields
$experience = json_encode(array_filter($data['experience'], fn($value) => !empty($value)));  // Remove empty fields
$skills = json_encode(array_filter($data['skills'], fn($value) => !empty($value)));  // Remove empty fields

$stmt->bind_param("isssss", $userId, $templateType, $personalInfo, $education, $experience, $skills);
$stmt->execute();

// Success response
$html = '
<p class="alert alert-success" role="alert">Resume generated successfully!</p>
<a href="./dashboard.php" type="button" class="btn btn-primary">View Resume</a>';

echo json_encode([
    'success' => true,
    'html' => $html
]);

?>
