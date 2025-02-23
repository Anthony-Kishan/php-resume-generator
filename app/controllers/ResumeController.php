<?php
// generateController.php
session_start();
require_once 'resumesModel.php';

class ResumeController extends Controller
{
    private $model;

    public function handleRequest()
    {
        header('Content-Type: application/json');

        $data = json_decode(file_get_contents('php://input'), true);
        if (!$data) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid data']);
            exit;
        }

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

        // Validate form data
        $validationErrors = $this->model->validateFormData($data);
        if (!empty($validationErrors)) {
            echo json_encode([
                'success' => false,
                'message' => implode(", ", $validationErrors)
            ]);
            exit;
        }

        // Process form data and insert into database
        $personalInfo = json_encode(array_filter($data['personalInfo'], fn($value) => !empty($value)));
        $education = json_encode(array_filter($data['education'], fn($value) => !empty($value)));
        $experience = json_encode(array_filter($data['experience'], fn($value) => !empty($value)));
        $skills = json_encode(array_filter($data['skills'], fn($value) => !empty($value)));

        $insertResult = $this->model->insertResume($userId, $personalInfo, $education, $experience, $skills);

        if ($insertResult) {
            echo json_encode(['success' => true]);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to insert resume']);
        }
    }
}