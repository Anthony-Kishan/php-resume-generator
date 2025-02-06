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

validateFormData($data);

function validateFormData($data)
{
    // Validate personal info
    $personalInfoFields = ['fullName', 'email', 'phone', 'location', 'summary'];
    foreach ($personalInfoFields as $field) {
        if (empty($data['personalInfo'][$field])) {
            echo json_encode([
                'success' => false,
                'message' => "Personal Info field '$field' is empty."
            ]);
            exit;
        }
    }

    // Validate education
    if (isset($data['education']) && is_array($data['education'])) {
        foreach ($data['education'] as $education) {
            $educationFields = ['degree', 'institution', 'startDate', 'endDate'];
            foreach ($educationFields as $field) {
                if (empty($education[$field])) {
                    echo json_encode([
                        'success' => false,
                        'message' => "Education field '$field' is empty."
                    ]);
                    exit;
                }
            }
        }
    }

    // Validate experience
    if (isset($data['experience']) && is_array($data['experience'])) {
        foreach ($data['experience'] as $experience) {
            $experienceFields = ['jobTitle', 'company', 'startDate', 'endDate', 'responsibilities'];
            foreach ($experienceFields as $field) {
                if (empty($experience[$field])) {
                    echo json_encode([
                        'success' => false,
                        'message' => "Experience field '$field' is empty."
                    ]);
                    exit;
                }
            }
        }
    }

    // Validate skills
    if (isset($data['skills']) && is_array($data['skills'])) {
        foreach ($data['skills'] as $skill) {
            $skillFields = ['skills', 'categories'];
            foreach ($skillFields as $field) {
                if (empty($skill[$field])) {
                    echo json_encode([
                        'success' => false,
                        'message' => "Skills field '$field' is empty."
                    ]);
                    exit;
                }
            }
        }
    }

    echo json_encode([
        'success' => true
    ]);
}

$stmt = $conn->prepare("INSERT INTO resumes (user_id, personal_info, education, experience, skills) VALUES (?, ?, ?, ?, ?)");

$personalInfo = json_encode(array_filter($data['personalInfo'], fn($value) => !empty($value)));
$education = json_encode(array_filter($data['education'], fn($value) => !empty($value)));
$experience = json_encode(array_filter($data['experience'], fn($value) => !empty($value)));
$skills = json_encode(array_filter($data['skills'], fn($value) => !empty($value)));

$stmt->bind_param("issss", $userId, $personalInfo, $education, $experience, $skills);
$stmt->execute();
