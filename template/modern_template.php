<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>{{fullName}} - Resume</title>
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
        <h1>{{fullName}}</h1>
        <p>{{email}} | {{phone}} | {{location}}</p>
    </header>
    <div class="section-title"></div>
    <div class='section'>
        <h3 class="fw-lighter text-uppercase">Summary</h3>
        <p>{{summary}}</p>
    </div>

    <div class="row">
        <div class="col-5">
            <!-- SKILLS SECTION -->
            <div class='section'>
                <h3 class='fw-lighter text-uppercase'>Skills</h3>
                <ul class='skills-list'>
                    {{skills}}
                </ul>
            </div>
        </div>
        <div class="col-7">
            <!-- EXPERIENCE -->
            <div class='section'>
                <h3 class='fw-lighter text-uppercase'>Experience</h3>
                <h5 class='text-uppercase fw-bold'>{{jobTitle}} | <span class='fs-6'>{{ExpformattedDateRange}}</span>
                </h5>
                <h5 class='text-capitalize'>{{company}}</h5>
                <li class='ms-4'>{{responsibilities}}</li>
            </div>


            <!-- EDUCATION SECTION -->
            <div class='section'>
                <h3 class='fw-lighter text-uppercase'>Education</h3>
                <h5 class='text-uppercase fw-bold'>{{institution}}</h5>
                <h5 class='text-uppercase fw-lighter'>{{degree}}</h5>
                <p>Grad. {{EduformattedDateRange}}</p>
            </div>
        </div>
    </div>






    <strong>{{languages}}</strong><br>
    <strong>{{certifications}}</strong>

</body>

</html>