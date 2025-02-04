<?php
session_start();
include('../config.php');

if (isset($_GET['id'])) {
    $id = ($_GET['id']);
    $resume_id = base64_decode($_GET['id']);
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("SELECT * FROM resumes WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $resume_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $resume = $result->fetch_assoc();

    $personal_info = json_decode($resume['personal_info'], true);
    $education = json_decode($resume['education'], true);
    $experience = json_decode($resume['experience'], true);
    $skills = json_decode($resume['skills'], true);

    // EDUCATION SECTION
    $eduList = '';
    foreach ($education as $edu) {
        $endDate = DateTime::createFromFormat('Y-m', $edu['endDate']);
        $endFormatted = $endDate->format('M Y');
        $EduformattedDateRange = strtoupper($endFormatted);

        $eduBlock = "
                <div class='education'>
                <h5 class='text-uppercase fw-bold'>" . $edu['institution'] . "</h5>
                    <h5 class='text-uppercase fw-lighter'>" . $edu['degree'] . "</h5>
                    <p>Grad." . $EduformattedDateRange . "</p>
                </div>";

        $eduList .= $eduBlock;
    }

    // EXPERIENCE SECTION
    $expList = '';
    foreach ($experience as $exp) {
        $startDate = DateTime::createFromFormat('Y-m', $exp['startDate']);
        $endDate = DateTime::createFromFormat('Y-m', $exp['endDate']);
        $startFormatted = $startDate->format('M Y');  // E.g., "June 2024"

        if (!empty($exp['endDate'])) {
            $endFormatted = $endDate->format('M Y');  // E.g., "Aug 2024"
        } else {
            $endFormatted = "Present";
        }
        $ExpformattedDateRange = strtoupper($startFormatted) . ' - ' . strtoupper($endFormatted);

        $expBlock = "
                    <div class='experience mb-3'>
                        <h5 class='text-uppercase fw-bold'>" . $exp['jobTitle'] . " | <span class='fs-6'>" . $ExpformattedDateRange . "</span></h5>
                        <h5 class='text-capitalize'>" . $exp['company'] . "</h5>
                        <li class='ms-4'>" . $exp['responsibilities'] . "</li>
                    </div>";

        $expList .= $expBlock;
    }

    // SKILLS SECTION
    $skillsList = '';
    foreach ($skills as $skill) {
        $skillBlock = '<div class="skill">
                            <h5 class="text-uppercase fw-bold">' . htmlspecialchars($skill['skills']) . '</h5>
                            <h5 class="text-muted">Categories:</h5>
                            <p>' . htmlspecialchars($skill['categories']) . '</p>
                        </div>';

        $skillsList .= $skillBlock;
    }
}

?>

<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title><?= $personal_info['fullName'] ?> - Resume</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <!-- <link rel="stylesheet" href="../assets/css/modern_template.css"> -->
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        h1,
        h2,
        h3 {
            color: #000000;
        }

        .section {
            margin-bottom: 20px;
        }

        .section-title {
            border-bottom: 2px solid #3498db;
            padding-bottom: 5px;
            margin-bottom: 10px;
        }

        .entry {
            margin-bottom: 15px;
        }

        .entry-title {
            font-weight: bold;
        }

        .entry-details {
            font-style: italic;
        }

        .skills-list {
            list-style-type: none;
            padding: 0;
            display: flex;
            flex-wrap: wrap;
        }

        .skills-list li {
            background-color: #ecf0f1;
            margin: 5px;
            padding: 5px 10px;
            border-radius: 3px;
        }
    </style>
</head>

<body>
    <header class="text-center">
        <h1><?= $personal_info['fullName'] ?></h1>
        <p><?= $personal_info['email'] ?> | <?= $personal_info['phone'] ?> | <?= $personal_info['location'] ?></p>
    </header>
    <div class="section-title"></div>
    <div class='section'>
        <h3 class="fw-lighter text-uppercase">Summary</h3>
        <p><?= $personal_info['summary'] ?></p>
    </div>

    <div class="row">
        <!-- SKILLS -->
        <div class="col-5">
            <div class='section'>
                <h3 class='fw-lighter text-uppercase mb-3'>Skills</h3>
                <?= $skillsList ?>
            </div>
        </div>

        <!-- EXPERIENCE -->
        <div class="col-7">
            <div class='section'>
                <h3 class='fw-lighter text-uppercase mb-3'>Experience</h3>
                <?= $expList ?>
            </div>

            <!-- EDUCATION SECTION -->
            <div class='section'>
                <h3 class='fw-lighter text-uppercase mb-3'>Education</h3>
                <?= $eduList ?>
            </div>
        </div>
    </div>

    <strong>{{languages}}</strong><br>
    <strong>{{certifications}}</strong>
</body>

</html>