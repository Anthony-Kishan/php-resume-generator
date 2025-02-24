<?php

# Resume Model

class Resume
{
    use Model;

    public function saveResume($userId, $data)
    {
        $resumeData = [
            'user_id' => $userId,
            'personal_info' => json_encode(array_filter($data['personalInfo'], fn($value) => !empty($value))),
            'education' => json_encode(array_filter($data['education'], fn($value) => !empty($value))),
            'experience' => json_encode(array_filter($data['experience'], fn($value) => !empty($value))),
            'skills' => json_encode(array_filter($data['skills'], fn($value) => !empty($value)))
        ];

        return $this->insert($resumeData);
    }
}
