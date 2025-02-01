<?php
session_start();
$is_logged_in = isset($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resume Generator</title>
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
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-file-alt me-2"></i>
                Resume Generator
            </a>
            <div class="ms-auto">
                <?php if (!$is_logged_in): ?>
                    <a class="btn btn-success" href="./users/login.php"><i class="fa-solid fa-arrow-right-to-bracket"></i> Login</a>
                    <a class="btn btn-danger" href="./users/register.php"><i class="fa-solid fa-user-plus"></i> Register</a>
                <?php else: ?>
                    <a class="btn btn-danger" href="./dashboard.php"><i class="fa-solid fa-chart-line"></i> Dashboard</a>
                    <a class="btn btn-danger" href="./users/logout.php"><i class="fa-solid fa-arrow-right-from-bracket"></i> Logout</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>


    <div class="container py-5">
        <div class="row mb-5">
            <div class="col-12 text-center">
                <h2 class="mb-4">Choose Your Resume Template</h2>
                <div class="row justify-content-center g-4">
                    <!-- Template 1 -->
                    <div class="col-md-4">
                        <div class="card template-card h-100" data-template="modern">
                            <img src="./assets/images/template_1.jpeg" class="card-img-top" alt="Modern Template">
                            <div class="card-body">
                                <h5 class="card-title">Modern Template</h5>
                                <p class="card-text">Clean and professional design with a modern touch.</p>
                            </div>
                        </div>
                    </div>
                    <!-- Template 2 -->
                    <div class="col-md-4">
                        <div class="card template-card h-100" data-template="creative">
                            <img src="./assets/images/template_2.jpeg" class="card-img-top" alt="Creative Template">
                            <div class="card-body">
                                <h5 class="card-title">Creative Template</h5>
                                <p class="card-text">Stand out with this creative and unique design.</p>
                            </div>
                        </div>
                    </div>
                    <!-- Template 3 -->
                    <div class="col-md-4">
                        <div class="card template-card h-100" data-template="classic">
                            <img src="./assets/images/template_3.jpeg" class="card-img-top" alt="Classic Template">
                            <div class="card-body">
                                <h5 class="card-title">Classic Template</h5>
                                <p class="card-text">Traditional and elegant design for formal applications.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Form Section -->
            <div class="col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <form id="resumeForm" class="needs-validation" novalidate>
                            <!-- Progress Indicator -->
                            <div class="progress mb-4" style="height: 3px;">
                                <div class="progress-bar" role="progressbar" style="width: 25%"></div>
                            </div>

                            <!-- Navigation -->
                            <div class="d-flex justify-content-between mb-4">
                                <button type="button" class="btn btn-outline-primary prev-section" disabled>
                                    <i class="fas fa-arrow-left me-2"></i>Previous
                                </button>
                                <div class="step-indicator">Step 1 of 4</div>
                                <button type="button" class="btn btn-primary next-section">
                                    Next<i class="fas fa-arrow-right ms-2"></i>
                                </button>
                            </div>

                            <!-- Personal Information Section -->
                            <div class="form-section active" data-step="1">
                                <h4 class="mb-4">Personal Information</h4>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Full Name</label>
                                        <input type="text" class="form-control" name="fullName" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" name="email" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Phone</label>
                                        <input type="tel" class="form-control" name="phone" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Location</label>
                                        <input type="text" class="form-control" name="location" required>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Professional Summary</label>
                                        <textarea class="form-control" name="summary" rows="4" required></textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Education Section -->
                            <div class="form-section" data-step="2">
                                <h4 class="mb-4">Education</h4>
                                <div id="educationContainer">
                                    <div class="education-entry mb-3 p-3 border rounded">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label">Degree</label>
                                                <input type="text" class="form-control" name="degree[]" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Institution</label>
                                                <input type="text" class="form-control" name="institution[]" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Start Date</label>
                                                <input type="month" class="form-control" name="eduStartDate[]" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">End Date</label>
                                                <input type="month" class="form-control" name="eduEndDate[]" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-outline-primary" id="addEducation">
                                    <i class="fas fa-plus me-2"></i>Add Education
                                </button>
                            </div>

                            <!-- Experience Section -->
                            <div class="form-section" data-step="3">
                                <h4 class="mb-4">Work Experience</h4>
                                <div id="experienceContainer">
                                    <div class="experience-entry mb-3 p-3 border rounded">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label">Job Title</label>
                                                <input type="text" class="form-control" name="jobTitle[]" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Company</label>
                                                <input type="text" class="form-control" name="company[]" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Start Date</label>
                                                <input type="month" class="form-control" name="expStartDate[]" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">End Date</label>
                                                <input type="month" class="form-control" name="expEndDate[]" required>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">Responsibilities</label>
                                                <textarea class="form-control" name="responsibilities[]" rows="3"
                                                    required></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-outline-primary" id="addExperience">
                                    <i class="fas fa-plus me-2"></i>Add Experience
                                </button>
                            </div>

                            <!-- Skills Section -->
                            <div class="form-section" data-step="4">
                                <h4 class="mb-4">Skills</h4>
                                <div class="mb-3">
                                    <label class="form-label">Skills (comma-separated)</label>
                                    <textarea class="form-control" name="skills" rows="3" required
                                        placeholder="e.g., Project Management, Team Leadership, Strategic Planning"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Languages</label>
                                    <textarea class="form-control" name="languages" rows="2"
                                        placeholder="e.g., English (Native), Spanish (Intermediate)"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Certifications</label>
                                    <textarea class="form-control" name="certifications" rows="2"
                                        placeholder="e.g., PMP Certification, Scrum Master"></textarea>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Preview Section -->
            <div class="col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-body preview-section" id="resumePreview">
                        <div class="text-center py-5">
                            <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                            <h5>Resume Preview</h5>
                            <p class="text-muted">Your resume preview will appear here as you fill out the form.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Generate Button -->
        <div class="row mt-4">
            <div class="col-12 text-center">
                <button type="button" class="btn btn-success btn-lg" id="generateResume">
                    <i class="fas fa-magic me-2"></i>Generate Resume
                </button>
            </div>
        </div>
    </div>

    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="./assets/js/script.js"></script>
</body>

</html>