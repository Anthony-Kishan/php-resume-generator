<?php
// session_start();
$is_logged_in = isset($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Resume</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <style>
        .template-card {
            cursor: pointer;
            transition: transform 0.3s;
        }

        .template-card:hover {
            transform: translateY(-5px);
        }

        .template-card.selected {
            border: 3px solid #0d6efd;
        }

        .form-section {
            display: none;
        }

        .form-section.active {
            display: block;
        }

        .preview-section {
            max-height: 800px;
            overflow-y: auto;
        }
    </style>
</head>

<body class="bg-light">
    <?php include('../navbar.php'); ?>

    <div class="container py-3">
        <div class="row mb-5">
            <!-- Preview Section -->
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-body preview-section" id="resumePreview">
                        <h5>Resume Preview</h5>
                        <div id="resumePreview">
                            <!-- RESUME WILL BE PREVIEW HERE DYNAMICALLY -->
                        </div>
                    </div>
                </div>
            </div>


            <!-- TEMPLATE SECTION -->
            <div class="col-4 text-center">
                <h2 class="mb-4">Choose Your Resume Template</h2>
                <div class="row justify-content-center g-2">
                    <!-- Template 1 -->
                    <div class="col-md-6">
                        <div class="card template-card h-100" data-template="modern">
                            <img src="../assets/images/template_1.jpeg" class="card-img-top" alt="Modern Template">
                            <div class="card-body">
                                <h5 class="card-title">Modern Template</h5>
                                <!-- <p class="card-text">Clean and professional design with a modern touch.</p> -->
                            </div>
                        </div>
                    </div>
                    <!-- Template 2 -->
                    <div class="col-md-6">
                        <div class="card template-card h-100" data-template="creative">
                            <img src="../assets/images/template_2.jpeg" class="card-img-top" alt="Creative Template">
                            <div class="card-body">
                                <h5 class="card-title">Creative Template</h5>
                                <!-- <p class="card-text">Stand out with this creative and unique design.</p> -->
                            </div>
                        </div>
                    </div>
                    <!-- Template 3 -->
                    <div class="col-md-6">
                        <div class="card template-card h-100" data-template="classic">
                            <img src="../assets/images/template_3.jpeg" class="card-img-top" alt="Classic Template">
                            <div class="card-body">
                                <h5 class="card-title">Classic Template</h5>
                                <!-- <p class="card-text">Traditional and elegant design for formal applications.</p> -->
                            </div>
                        </div>
                    </div>
                    <!-- Template 4 -->
                    <div class="col-md-6">
                        <div class="card template-card h-100" data-template="classic">
                            <img src="../assets/images/template_3.jpeg" class="card-img-top" alt="Classic Template">
                            <div class="card-body">
                                <h5 class="card-title">Classic Template</h5>
                                <!-- <p class="card-text">Traditional and elegant design for formal applications.</p> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script src="../assets/js/script.js"></script>

</body>

</html>