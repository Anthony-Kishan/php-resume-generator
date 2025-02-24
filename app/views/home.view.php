<?php
$is_logged_in = User::is_logged_in();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resume Generator</title>
    <!-- Add the necessary CSS files -->
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/sweetalert2.min.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/navbar.css">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/style.css">
</head>

<body class="bg-light">
    <?php include('navbar.view.php'); ?>

    <!-- SUCCESS MODAL -->
    <div class="modal fade" tabindex="-1" id="successModal">
        <div class="modal-dialog">
            <div class="modal-content" style="border: 2px solid rgb(4, 167, 78); background-color:rgb(165, 255, 206);">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fa-regular fa-circle-check" style="color:rgb(30, 249, 129);"></i>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body success-modal-body text-center">
                    <p>Resume generated successfully!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a href="./dashboard.php" type="button" class="btn btn-primary">Go to Dashboard</a>
                </div>
            </div>
        </div>
    </div>

    <!-- ERROR MODAL -->
    <div class="modal fade" tabindex="-1" id="errorModal">
        <div class="modal-dialog">
            <div class="modal-content" style="border: 2px solid rgb(167, 4, 4);">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fa-regular fa-circle-xmark" style="color:rgb(249, 30, 30);"></i>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body error-modal-body text-center">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- LOGIN FIRST -->
    <!-- <div class="modal fade" tabindex="-1" id="loginFirstModal">
        <div class="modal-dialog">
            <div class="modal-content loginFirstModal-Content" style="border: 2px solid rgb(4, 94, 167);">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fa-solid fa-user-plus" style="color:rgb(30, 132, 249);"></i>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body loginFirst-modal-body">
                    Sign Up Form (this will be inside the modal)
                    <div class="form-container sign-up-container">
                        <h2 class="text-center">Sign Up</h2>
                        <form id="signup-form" method="POST">
                            <div class="form-group mb-3">
                                <label for="username" class="text-start">Username:</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="email" class="text-start">Email:</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="password" class="text-start">Password:</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-primary mb-3">Register</button>
                                <a href="javascript:void(0);" class="d-block" id="show-login-form">Already Have an
                                    Account?
                                    Login</a>
                            </div>
                        </form>
                    </div>

                    Login Form (this will be inside the modal)
                    <div class="form-container login-container">
                        <h2 class="text-center">Login</h2>
                        <form id="login-form" method="POST">
                            <div class="form-group mb-3">
                                <label for="login-email" class="text-start">Email:</label>
                                <input type="email" class="form-control" id="login-email" name="email" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="login-password" class="text-start">Password:</label>
                                <input type="password" class="form-control" id="login-password" name="password"
                                    required>
                            </div>
                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-primary mb-3">Login</button>
                                <a href="javascript:void(0);" class="d-block" id="show-signup-form">Don't Have an
                                    Account?
                                    Sign
                                    Up</a>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div> -->


    <div class="container py-5">
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
                                        <input type="text" class="form-control" name="fullName" id="fullName" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" name="mail" id="mail" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Phone</label>
                                        <input type="tel" class="form-control" name="phone" id="phone" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Location</label>
                                        <input type="text" class="form-control" name="location" required>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Professional Summary</label>
                                        <textarea class="form-control" name="summary" id="summary" rows="4"
                                            required></textarea>
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
                                                <input type="text" class="form-control" name="degree" id="degree"
                                                    required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Institution</label>
                                                <input type="text" class="form-control" name="institution"
                                                    id="institution" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Start Date</label>
                                                <input type="month" class="form-control" name="eduStartDate"
                                                    id="eduStartDate" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">End Date</label>
                                                <input type="month" class="form-control" name="eduEndDate"
                                                    id="eduEndDate" required>
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
                                                <input type="text" class="form-control" name="jobTitle" id="jobTitle"
                                                    required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Company</label>
                                                <input type="text" class="form-control" name="company" id="company"
                                                    required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Start Date</label>
                                                <input type="month" class="form-control" name="expStartDate"
                                                    id="expStartDate" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">End Date</label>
                                                <input type="month" class="form-control" name="expEndDate"
                                                    id="expEndDate" required>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">Responsibilities</label>
                                                <textarea class="form-control" name="responsibilities"
                                                    id="responsibilities" rows="3" required></textarea>
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
                                <div id="skillsContainer">
                                    <div class="row g-3">
                                        <div class="skills-entry mb-3 p-3 border rounded">
                                            <label class="form-label">Skills (comma-separated)</label>
                                            <input class="form-control" name="skills" id="skills" rows="3" required
                                                placeholder="e.g., Project Management, Team Leadership, Strategic Planning">

                                            <div class="ms-4 mb-3">
                                                <label class="form-label">Categories</label>
                                                <input class="form-control" name="categories" id="categories" rows="3"
                                                    required
                                                    placeholder="e.g., Project Management, Team Leadership, Strategic Planning">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-outline-primary" id="addSkills">
                                    <i class="fas fa-plus me-2"></i>Add Skills
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Preview Section -->
            <div class="col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-body preview-section" id="resumePreview">
                        <h5>Resume Preview</h5>
                        <div class="py-5">
                            <header style="text-align: center; margin-bottom: 30px;">
                                <h1 style="margin: 0; font-size: 32px; font-weight: normal;">
                                    <span style="font-weight: normal;" data-preview="fullName">Your Name</span>
                                </h1>
                                <p style="margin: 10px 0; color: #666;">
                                    DOB: 07 Feb 2003
                                </p>
                                <p style="margin: 5px 0;">
                                    <a href="" data-preview="mail"
                                        style="color: #0066cc; text-decoration: none;">Email</a> |
                                    <span data-preview="phone">Phone</span> |
                                    <a href="#" style="color: #0066cc; text-decoration: none;">Portfolio</a> |
                                    <a href="#" style="color: #0066cc; text-decoration: none;">LinkedIn</a> |
                                    <a href="#" style="color: #0066cc; text-decoration: none;">GitHub</a>
                                </p>
                            </header>

                            <!-- Summary Section -->
                            <section style="margin-bottom: 30px;">
                                <h2
                                    style="font-size: 14px; text-transform: uppercase; color: #666; margin-bottom: 10px;">
                                    Summary</h2>
                                <p style="margin: 0; text-align: justify;" data-preview="summary">Write your summary
                                </p>
                            </section>

                            <div style="display: flex; gap: 40px;">
                                <div style="flex: 1;">
                                    <!-- Skills Section -->
                                    <section style="margin-bottom: 30px;">
                                        <h2
                                            style="font-size: 14px; text-transform: uppercase; color: #666; margin-bottom: 10px;">
                                            Skills</h2>

                                        <div id="skillsPreviewContainer">
                                            <div class="skills-preview" style="margin-bottom: 20px;">
                                                <h3 style="font-size: 13px; margin: 0 0 5px 0;" data-preview="skills">
                                                </h3>
                                                <p style="margin: 0; color: #666; font-size: 12px;">Categories:</p>
                                                <ul style="margin: 5px 0; padding-left: 20px; font-size: 12px;">
                                                    <li data-preview="categories"></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </section>
                                </div>

                                <div style="flex: 1;">
                                    <!-- Experience Section -->
                                    <section style="margin-bottom: 30px;">
                                        <h2
                                            style="font-size: 14px; text-transform: uppercase; color: #666; margin-bottom: 10px;">
                                            Experience
                                        </h2>
                                        <div id="experiencePreviewContainer">
                                            <div class="experience-preview" style="margin-bottom: 20px;">
                                                <span style="font-size: 13px; margin: 0 0 5px 0;"
                                                    data-preview="jobTitle">Your Job Title</span> | <span
                                                    style="font-size: 13px; margin: 0 0 5px 0;"
                                                    data-preview="expStartDate">Start Date</span> – <span
                                                    style="font-size: 13px; margin: 0 0 5px 0;"
                                                    data-preview="expEndDate">End Date</span> |
                                                <p style="margin: 0 0 5px 0; font-size: 12px;" data-preview="company">
                                                    Company</p>
                                                <ul style="margin: 5px 0; padding-left: 20px; font-size: 12px;"
                                                    data-preview="responsibilities">
                                                    Your Responsibilities
                                                </ul>
                                            </div>
                                        </div>
                                    </section>

                                    <!-- Education Section -->
                                    <section>
                                        <h2
                                            style="font-size: 14px; text-transform: uppercase; color: #666; margin-bottom: 10px;">
                                            Education</h2>
                                        <div id="educationPreviewContainer">
                                            <div class="education-preview" style="margin-bottom: 20px;">
                                                <h3 style="font-size: 13px; margin: 0 0 5px 0;"
                                                    data-preview="institution">Your Institution</h3>
                                                <p style="margin: 0; font-size: 12px;" data-preview="degree">Degree
                                                </p>
                                                <span style="margin: 0; font-size: 12px;"
                                                    data-preview="eduStartDate">Start Date</span> - <span
                                                    style="margin: 0; font-size: 12px;" data-preview="eduEndDate">End
                                                    Date</span>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <?php if (!$is_logged_in): ?>
            <div class="row mt-4">
                <div class="col-12 text-center">
                    <button type="button" class="btn btn-success btn-lg" onclick="showLoginAlert()">
                        <i class=" fas fa-magic me-2"></i>Generate Resume
                    </button>
                </div>
            </div>
        <?php else: ?>
            <div class="row mt-4">
                <div class="col-12 text-center">
                    <button type="button" class="btn btn-success btn-lg" id="generateResume">
                        <i class=" fas fa-magic me-2"></i>Generate Resume
                    </button>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <div id="config" data-root="<?php echo ROOT; ?>"></div>

    <!-- Add the necessary JavaScript files -->
    <script src="<?= ROOT ?>/assets/js/jquery.min.js"></script>
    <script src="<?= ROOT ?>/assets/js/sweetalert2.min.js"></script>
    <script src="<?= ROOT ?>/assets/js/bootstrap.bundle.min.js"></script>
    <!-- <script src="<?= ROOT ?>/assets/js/bootstrap.min.js"></script> -->

    <script src="<?= ROOT ?>/assets/js/script.js"></script>
</body>

</html>