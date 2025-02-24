<?php

# ResumeController.php

header('Content-Type: application/json');

class ResumeController extends Controller
{
    public function generate()
    {

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['error' => 'Method not allowed']);
            exit;
        }

        if (!isset($_SESSION['USER']['id'])) {
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized. Please log in.']);
            exit;
        }

        $data = json_decode(file_get_contents('php://input'), true);
        
        if (!$data) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid data']);
            exit;
        }

        // Validate Data
        $validator = new ResumeValidator();
        $validationResult = $validator->validate($data);
        if (!$validationResult['success']) {
            echo json_encode($validationResult);
            exit;
        }

        // Save resume
        $resumeModel = new Resume();
        $resumeSaved = $resumeModel->saveResume($_SESSION['USER']['id'], $data);

        if ($resumeSaved) {
            echo json_encode(['success' => true, 'message' => 'Resume generated successfully.']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to save resume.']);
        }
    }
}
