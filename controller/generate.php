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

// $requiredFields = ['template', 'personalInfo', 'education', 'experience', 'skills'];

// foreach ($requiredFields as $field) {
//     if (empty($data[$field])) {
//         echo json_encode([
//             'success' => false,
//             'message' => "Field '$field' is empty or missing."
//         ]);
//         exit;
//     }
// }

// if (isset($data['personalInfo']) && is_array($data['personalInfo'])) {
//     foreach ($data['personalInfo'] as $key => $value) {
//         if (empty($value)) {
//             echo json_encode([
//                 'success' => false,
//                 'message' => "Personal information field '$key' is empty."
//             ]);
//             exit;
//         }
//     }
// } else {
//     echo json_encode([
//         'success' => false,
//         'message' => "Personal information is incomplete or invalid."
//     ]);
//     exit;
// }

// if (isset($data['education']) && is_array($data['education'])) {
//     foreach ($data['education'] as $education) {
//         if (empty($education['degree']) || empty($education['institution']) || empty($education['startDate']) || empty($education['endDate'])) {
//             echo json_encode([
//                 'success' => false,
//                 'message' => "Education field is incomplete or missing a subfield."
//             ]);
//             exit;
//         }
//     }
// } else {
//     echo json_encode([
//         'success' => false,
//         'message' => "Education information is incomplete or invalid."
//     ]);
//     exit;
// }

// if (isset($data['experience']) && is_array($data['experience'])) {
//     foreach ($data['experience'] as $experience) {
//         if (empty($experience['jobTitle']) || empty($experience['company']) || empty($experience['responsibilities']) || empty($experience['startDate']) || empty($experience['endDate'])) {
//             echo json_encode([
//                 'success' => false,
//                 'message' => "Experience field is incomplete or missing a subfield."
//             ]);
//             exit;
//         }
//     }
// } else {
//     echo json_encode([
//         'success' => false,
//         'message' => "Experience information is incomplete or invalid."
//     ]);
//     exit;
// }

// if (isset($data['skills']) && is_array($data['skills'])) {
//     foreach ($data['skills'] as $skill) {
//         if (empty($skill['skills']) || empty($skill['categories'])) {
//             echo json_encode([
//                 'success' => false,
//                 'message' => "Skill field is incomplete or missing a subfield."
//             ]);
//             exit;
//         }
//     }
// } else {
//     echo json_encode([
//         'success' => false,
//         'message' => "Skills information is incomplete or invalid."
//     ]);
//     exit;
// }







function validateFields($data, $requiredFields)
{
    foreach ($requiredFields as $field => $subfields) {
        if (empty($data[$field])) {
            echo json_encode([
                'success' => false,
                'message' => "Field '$field' is empty or missing."
            ]);
            exit;
        }

        if (is_array($data[$field])) {
            foreach ($data[$field] as $item) {
                if (is_array($subfields)) {
                    foreach ($subfields as $subfield) {
                        if (empty($item[$subfield])) {
                            echo json_encode([
                                'success' => false,
                                'message' => ucfirst($field) . " field subfield '$subfield' is empty."
                            ]);
                            exit;
                        }
                    }
                }
            }
        }
    }
    return true;
}

$requiredFields = [
    'personal_info' => ['fullName', 'email', 'phone', 'location', 'summary'],
    'education' => ['degree', 'institution', 'startDate', 'endDate'],
    'experience' => ['jobTitle', 'company', 'responsibilities', 'startDate', 'endDate'],
    'skills' => ['skills', 'categories']
];

validateFields($data, $requiredFields);


$stmt = $conn->prepare("INSERT INTO resumes (user_id, template_type, personal_info, education, experience, skills) VALUES (?, ?, ?, ?, ?, ?)");

$templateType = $data['template'];

$personalInfo = json_encode(array_filter($data['personalInfo'], fn($value) => !empty($value)));  // Remove empty fields
$education = json_encode(array_filter($data['education'], fn($value) => !empty($value)));  // Remove empty fields
$experience = json_encode(array_filter($data['experience'], fn($value) => !empty($value)));  // Remove empty fields
$skills = json_encode(array_filter($data['skills'], fn($value) => !empty($value)));  // Remove empty fields

$stmt->bind_param("isssss", $userId, $templateType, $personalInfo, $education, $experience, $skills);
$stmt->execute();

// Success response
$html = '

';

echo json_encode([
    'success' => true,
    'html' => $html
]);
