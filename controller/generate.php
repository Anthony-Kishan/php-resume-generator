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

include ('./controller/parse_resume_details.php');

$html = '
    <header style="text-align: center; margin-bottom: 30px;">
        <h1 style="margin: 0; font-size: 32px; font-weight: normal;">
            <span style="font-weight: normal;">' . htmlspecialchars($personal_info["fullName"]) . '</span>
            <span style="font-weight: bold;">Modhu</span>
        </h1>
        <p style="margin: 10px 0; color: #666;">
            DOB: 07 Feb 2003
        </p>
        <p style="margin: 5px 0;">
            <a href="mailto:kishanmodhu@gmail.com"
                style="color: #0066cc; text-decoration: none;">kishanmodhu@gmail.com</a> |
            <span>01629743788</span> |
            <a href="#" style="color: #0066cc; text-decoration: none;">Portfolio</a> |
            <a href="#" style="color: #0066cc; text-decoration: none;">LinkedIn</a> |
            <a href="#" style="color: #0066cc; text-decoration: none;">GitHub</a>
        </p>
    </header>

    <!-- Summary Section -->
    <section style="margin-bottom: 30px;">
        <h2 style="font-size: 14px; text-transform: uppercase; color: #666; margin-bottom: 10px;">Summary</h2>
        <p style="margin: 0; text-align: justify;">Dedicated and skilled web developer with experience in responsive
            frontend design, backend development using Python Django, and database management. Proficient in PHP and
            Laravel, with a strong passion for building scalable web applications and optimizing performance through
            modern development practices.</p>
    </section>

    <div style="display: flex; gap: 40px;">
        <!-- Left Column -->
        <div style="flex: 1;">
            <!-- Skills Section -->
            <section style="margin-bottom: 30px;">
                <h2 style="font-size: 14px; text-transform: uppercase; color: #666; margin-bottom: 10px;">Skills</h2>

                <div style="margin-bottom: 20px;">
                    <h3 style="font-size: 13px; margin: 0 0 5px 0;">RESPONSIVE FRONTEND DESIGN</h3>
                    <p style="margin: 0; color: #666; font-size: 12px;">Categories:</p>
                    <ul style="margin: 5px 0; padding-left: 20px; font-size: 12px;">
                        <li>Responsive Design</li>
                        <li>Mobile-First Design</li>
                        <li>Cross-Browser Compatibility</li>
                        <li>Performance Optimization</li>
                    </ul>
                    <p style="margin: 5px 0; color: #666; font-size: 12px;">Tools:</p>
                    <p style="margin: 0; font-size: 12px;">• HTML & CSS • Bootstrap • JavaScript</p>
                </div>

                <div style="margin-bottom: 20px;">
                    <h3 style="font-size: 13px; margin: 0 0 5px 0;">BACKEND DEVELOPMENT</h3>
                    <p style="margin: 0; color: #666; font-size: 12px;">Categories:</p>
                    <ul style="margin: 5px 0; padding-left: 20px; font-size: 12px;">
                        <li>Web App Development</li>
                        <li>Django Models and ORM</li>
                        <li>RESTful API Development</li>
                        <li>Authentication & Security</li>
                        <li>Database Management</li>
                    </ul>
                    <p style="margin: 5px 0; color: #666; font-size: 12px;">Tools:</p>
                    <p style="margin: 0; font-size: 12px;">• Django Framework • Python (OOP)</p>
                    <p style="margin: 0; font-size: 12px;">• PHP • Laravel</p>
                </div>

                <div style="margin-bottom: 20px;">
                    <h3 style="font-size: 13px; margin: 0 0 5px 0;">DATABASE MANAGEMENT</h3>
                    <p style="margin: 0; color: #666; font-size: 12px;">Categories:</p>
                    <ul style="margin: 5px 0; padding-left: 20px; font-size: 12px;">
                        <li>ORM Integration</li>
                        <li>Performance Optimization</li>
                    </ul>
                    <p style="margin: 5px 0; color: #666; font-size: 12px;">Tools:</p>
                    <p style="margin: 0; font-size: 12px;">• PostgreSQL • MySQL</p>
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
                    <h3 style="font-size: 13px; margin: 0 0 5px 0;">PYTHON DJANGO INTERN | June 2024 – Aug 2024 |</h3>
                    <p style="margin: 0 0 5px 0; font-size: 12px;">European IT Institute, Mirpur 10 DHAKA, BANGLADESH
                    </p>
                    <ul style="margin: 5px 0; padding-left: 20px; font-size: 12px;">
                        <li>Developed web applications using Python Django framework, focusing on building and managing
                            backend functionality.</li>
                        <li>Implemented dynamic authentication and authorization systems ensuring secure user access and
                            data protection.</li>
                        <li>Applied Object-Oriented Programming (OOP) principles to design scalable and maintainable
                            code.</li>
                        <li>Utilized Python fundamentals to write efficient and clean code, ensuring robust application
                            performance.</li>
                    </ul>
                </div>

                <div style="margin-bottom: 20px;">
                    <h3 style="font-size: 13px; margin: 0 0 5px 0;">WEB DESIGN AND DEVELOPMENT FOR FREELANCING</h3>
                    <p style="margin: 0 0 5px 0; font-size: 12px;">LEVEL 3 TRAINEE</p>
                    <p style="margin: 0 0 5px 0; font-size: 12px;">SEP 2024 – NOV 2024 | European IT Institute, Mirpur
                        10</p>
                    <p style="margin: 0 0 5px 0; font-size: 12px;">DHAKA, BANGLADESH</p>
                    <ul style="margin: 5px 0; padding-left: 20px; font-size: 12px;">
                        <li>Completed an advanced course in Web Development and Design under a government organization
                            (NHHDP) in Bangladesh, focusing on modern web principles and modern web technologies.</li>
                        <li>Gained proficiency in HTML, CSS, Bootstrap, JavaScript, PHP, Laravel, and MySQL.</li>
                        <li>Acquired practical experience in designing and developing responsive websites and web
                            applications with an emphasis on user experience (UX).</li>
                    </ul>
                </div>
            </section>

            <!-- Education Section -->
            <section>
                <h2 style="font-size: 14px; text-transform: uppercase; color: #666; margin-bottom: 10px;">Education</h2>

                <div style="margin-bottom: 20px;">
                    <h3 style="font-size: 13px; margin: 0 0 5px 0;">KURIGRAM POLYTECHNIC INSTITUTE</h3>
                    <p style="margin: 0; font-size: 12px;">DIPLOMA IN COMPUTER SCIENCE</p>
                    <p style="margin: 0; font-size: 12px;">Expected Grad: Jan 2029 | Kurigram, Bangladesh</p>
                </div>

                <div style="margin-bottom: 20px;">
                    <h3 style="font-size: 13px; margin: 0 0 5px 0;">SAMIR UDDIN SCHOOL & COLLEGE</h3>
                    <p style="margin: 0; font-size: 12px;">DEPARTMENT OF SCIENCE</p>
                    <p style="margin: 0; font-size: 12px;">Grad: Mar 2020 | CGPA: 4.55/5.00 Nijhumnari, Bangladesh</p>
                </div>
            </section>
        </div>
    </div>
';




echo json_encode([
    'success' => true,
    'html' => $html
]);
