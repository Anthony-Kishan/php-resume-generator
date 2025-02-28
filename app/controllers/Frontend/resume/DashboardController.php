<?php

# DashboardController.php

class DashboardController extends Controller
{
    public function index()
    {
        if (!isset($_SESSION['USER']) || !isset($_SESSION['USER']['id'])) {
            redirect('auth/login');
            exit;
        }

        $resumeModel = new Resume();
        $userId = $_SESSION['USER']['id'];

        $resumes = $resumeModel->getUserResumes($userId);

        $this->view('/resume/dashboard', ['resumes' => $resumes]);

    }
}