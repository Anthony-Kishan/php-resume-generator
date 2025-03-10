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