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

    return json_encode([
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



// PREVIEW RESUME

include('./parse_resume_details.php');

$html = '
    <header style="text-align: center; margin-bottom: 30px;">
        <h1 style="margin: 0; font-size: 32px; font-weight: normal;">
            <span style="font-weight: normal;">' . htmlspecialchars($firstName) . '</span>
            <span style="font-weight: bold;">' . htmlspecialchars($lastName) . '</span>
        </h1>
        <p style="margin: 10px 0; color: #666;">
            DOB: 07 Feb 2003
        </p>
        <p style="margin: 5px 0;">
            <a href="mailto:' . htmlspecialchars($personal_info['email']) . ' "
                style="color: #0066cc; text-decoration: none;">' . htmlspecialchars($personal_info['email']) . '</a> |
            <span>' . htmlspecialchars($personal_info['phone']) . '</span> |
            <a href="#" style="color: #0066cc; text-decoration: none;">Portfolio</a> |
            <a href="#" style="color: #0066cc; text-decoration: none;">LinkedIn</a> |
            <a href="#" style="color: #0066cc; text-decoration: none;">GitHub</a>
        </p>
    </header>

    <!-- Summary Section -->
    <section style="margin-bottom: 30px;">
        <h2 style="font-size: 14px; text-transform: uppercase; color: #666; margin-bottom: 10px;">Summary</h2>
        <p style="margin: 0; text-align: justify;">' . htmlspecialchars($personal_info['summary']) . '</p>
    </section>

    <div style="display: flex; gap: 40px;">
        <!-- Left Column -->
        <div style="flex: 1;">
            <!-- Skills Section -->
            <section style="margin-bottom: 30px;">
                <h2 style="font-size: 14px; text-transform: uppercase; color: #666; margin-bottom: 10px;">Skills</h2>
                <div style="margin-bottom: 20px;">
                    ' . $skillsList . '
                    <p style="margin: 5px 0; color: #666; font-size: 12px;">Tools:</p>
                    <p style="margin: 0; font-size: 12px;">• HTML & CSS • Bootstrap • JavaScript</p>
                </div>


                <div style="margin-bottom: 20px;">
                    <h3 style="font-size: 13px; margin: 0 0 5px 0;">TECHNOLOGIES</h3>
                    <ul style="margin: 5px 0; padding-left: 20px; font-size: 12px;">
                        <li>Git • VS Code • Windows OS • JSON</li>
                        <li>Docker</li>
                    </ul>
                </div>

                <div style="margin-bottom: 20px;">
                    <h3 style="font-size: 13px; margin: 0 0 5px 0;">OTHERS</h3>
                    <ul style="margin: 5px 0; padding-left: 20px; font-size: 12px;">
                        <li>Graphics Design • Video Editing</li>
                        <li>3D Design • Animation</li>
                        <li>Electronics Device Making</li>
                    </ul>
                </div>
            </section>
        </div>

        <!-- Right Column -->
        <div style="flex: 1;">
            <!-- Experience Section -->
            <section style="margin-bottom: 30px;">
                <h2 style="font-size: 14px; text-transform: uppercase; color: #666; margin-bottom: 10px;">Experience
                </h2>
                <div style="margin-bottom: 20px;">
                    ' . $expList . '
                </div>
            </section>

            <!-- Education Section -->
            <section>
                <h2 style="font-size: 14px; text-transform: uppercase; color: #666; margin-bottom: 10px;">Education</h2>
                ' . $eduList . '
            </section>
        </div>
    </div>
';




echo json_encode([
    'success' => true,
    'html' => $html
]);
