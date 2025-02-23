<?php
// Resume.php

class Resume
{
    use Model;

    protected $table = 'resumes';

    protected $allowedColumns = [
        'name',
    ];

    public function insertResume($userId, $personalInfo, $education, $experience, $skills)
    {
        $stmt = $this->conn->prepare("INSERT INTO resumes (user_id, personal_info, education, experience, skills) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issss", $userId, $personalInfo, $education, $experience, $skills);
        return $stmt->execute();

        
    }

    public function validateFormData($data)
    {
        // Validation logic as a separate method
        $validationErrors = [];

        // Validate personal info
        $personalInfoFields = ['fullName', 'email', 'phone', 'location', 'summary'];
        foreach ($personalInfoFields as $field) {
            if (empty($data['personalInfo'][$field])) {
                $validationErrors[] = "Personal Info field '$field' is empty.";
            }
        }

        // Validate education
        if (isset($data['education']) && is_array($data['education'])) {
            foreach ($data['education'] as $education) {
                $educationFields = ['degree', 'institution', 'startDate', 'endDate'];
                foreach ($educationFields as $field) {
                    if (empty($education[$field])) {
                        $validationErrors[] = "Education field '$field' is empty.";
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
                        $validationErrors[] = "Experience field '$field' is empty.";
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
                        $validationErrors[] = "Skills field '$field' is empty.";
                    }
                }
            }
        }

        return $validationErrors;
    }
}
