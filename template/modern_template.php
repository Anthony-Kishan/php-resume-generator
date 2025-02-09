<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $personal_info['fullName'] ?> - Resume</title>
</head>

<body
    style="font-family: Arial, sans-serif; max-width: 800px; margin: 0 auto; padding: 40px 20px; color: #333; line-height: 1.6;">
    <!-- Header Section -->
    <header style="text-align: center; margin-bottom: 30px;">
        <h1 style="margin: 0; font-size: 32px; font-weight: normal;">
            <span style="font-weight: normal;"><?= $firstName ?></span>
            <span style="font-weight: bold;"><?= $lastName ?></span>
        </h1>
        <p style="margin: 10px 0; color: #666;">
            DOB: 07 Feb 2003
        </p>
        <p style="margin: 5px 0;">
            <a href="mailto:kishanmodhu@gmail.com"
                style="color: #0066cc; text-decoration: none;"><?= $personal_info['email'] ?></a> |
            <span><?= $personal_info['phone'] ?></span> |
            <a href="#" style="color: #0066cc; text-decoration: none;">Portfolio</a> |
            <a href="#" style="color: #0066cc; text-decoration: none;">LinkedIn</a> |
            <a href="#" style="color: #0066cc; text-decoration: none;">GitHub</a>
        </p>
    </header>

    <!-- Summary Section -->
    <section style="margin-bottom: 30px;">
        <h2 style="font-size: 14px; text-transform: uppercase; color: #666; margin-bottom: 10px;">Summary</h2>
        <p style="margin: 0; text-align: justify;"><?= $personal_info['summary'] ?></p>
    </section>

    <div style="display: flex; gap: 40px;">
        <!-- Left Column -->
        <div style="flex: 1;">
            <!-- Skills Section -->
            <section style="margin-bottom: 30px;">
                <h2 style="font-size: 14px; text-transform: uppercase; color: #666; margin-bottom: 10px;">Skills</h2>

                <div style="margin-bottom: 20px;">
                    <h3 style="font-size: 13px; margin: 0 0 5px 0;"><?= htmlspecialchars($skill['skills']) ?></h3>
                    <p style="margin: 0; color: #666; font-size: 12px;">Categories:</p>
                    <ul style="margin: 5px 0; padding-left: 20px; font-size: 12px;">
                        <li><?= htmlspecialchars($skill['categories']) ?></li>
                    </ul>
                    <p style="margin: 5px 0; color: #666; font-size: 12px;">Tools:</p>
                    <p style="margin: 0; font-size: 12px;">• HTML & CSS • Bootstrap • JavaScript</p>
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
                    <h3 style="font-size: 13px; margin: 0 0 5px 0;"><?= $exp['jobTitle'] ?> | <?= $startFormatted ?> – <?= $endFormatted ?> |</h3>
                    <p style="margin: 0 0 5px 0; font-size: 12px;"><?= $exp['company'] ?>, Location
                    </p>
                    <ul style="margin: 5px 0; padding-left: 20px; font-size: 12px;">
                        <li><?= $exp['responsibilities'] ?></li>
                    </ul>
                </div>
            </section>

            <!-- Education Section -->
            <section>
                <h2 style="font-size: 14px; text-transform: uppercase; color: #666; margin-bottom: 10px;">Education</h2>

                <div style="margin-bottom: 20px;">
                    <h3 style="font-size: 13px; margin: 0 0 5px 0;"><?= $edu['institution'] ?></h3>
                    <p style="margin: 0; font-size: 12px;"><?= $edu['degree'] ?></p>
                    <p style="margin: 0; font-size: 12px;">Expected Grad: <?= $endFormatted ?> | <?= 'location' ?></p>
                </div>
            </section>
        </div>
    </div>
</body>

</html>