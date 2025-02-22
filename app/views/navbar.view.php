<?php
$is_logged_in = User::is_logged_in();
?>

<!-- Navbar -->
<?php if (!$is_logged_in): ?>
    <nav class="navbar navbar-expand-lg navbar-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-file-alt me-2"></i>
                Resume Generator
            </a>
            <div class="auth-buttons">
                <a class="btn btn-login" href="<?= ROOT ?>/auth/login">
                    <i class="fas fa-arrow-right-to-bracket me-2"></i>Login
                </a>
                <a class="btn btn-signup" href="<?= ROOT ?>/auth/signup">
                    <i class="fas fa-user-plus me-2"></i>Signup
                </a>
            </div>
        </div>
    </nav>
<?php else: ?>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-file-alt me-2"></i>
                Resume Generator
            </a>
            <div class="user-dropdown">
                <div class="dropdown">
                    <button class="btn dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="fas fa-user-circle me-2"></i>
                        <span><?= $_SESSION['USER']['name'] ?></span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-chart-line"></i>
                                Dashboard
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-user-gear"></i>
                                Profile Settings
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item text-danger" href="<?= ROOT ?>/auth/logout">
                                <i class="fas fa-arrow-right-from-bracket"></i>
                                Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
<?php endif; ?>