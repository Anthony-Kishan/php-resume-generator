<?php
# ResumeValidator

class ResumeValidator
{
    public function validate($data)
    {
        $errors = [];

        // Validate personal info
        $requiredPersonalFields = ['fullName', 'email', 'phone', 'location', 'summary'];
        foreach ($requiredPersonalFields as $field) {
            if (empty($data['personalInfo'][$field])) {
                return ['success' => false, 'message' => "Personal Info field '$field' is empty."];
            }
        }

        // Validate education
        if (isset($data['education']) && is_array($data['education'])) {
            foreach ($data['education'] as $education) {
                $requiredEducationFields = ['degree', 'institution', 'startDate', 'endDate'];
                foreach ($requiredEducationFields as $field) {
                    if (empty($education[$field])) {
                        return ['success' => false, 'message' => "Education field '$field' is empty."];
                    }
                }
            }
        }

        // Validate experience
        if (isset($data['experience']) && is_array($data['experience'])) {
            foreach ($data['experience'] as $experience) {
                $requiredExperienceFields = ['jobTitle', 'company', 'startDate', 'endDate', 'responsibilities'];
                foreach ($requiredExperienceFields as $field) {
                    if (empty($experience[$field])) {
                        return ['success' => false, 'message' => "Experience field '$field' is empty."];
                    }
                }
            }
        }

        // Validate skills
        if (isset($data['skills']) && is_array($data['skills'])) {
            foreach ($data['skills'] as $skill) {
                $requiredSkillFields = ['skills', 'categories'];
                foreach ($requiredSkillFields as $field) {
                    if (empty($skill[$field])) {
                        return ['success' => false, 'message' => "Skills field '$field' is empty."];
                    }
                }
            }
        }

        return ['success' => true];
    }
}
