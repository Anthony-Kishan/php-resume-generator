<?php
$is_logged_in = User::is_logged_in();
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="#">
            <i class="fas fa-file-alt me-2"></i>
            Resume Generator
        </a>
        <div class="ms-auto align-items-center">
            <?php if (!$is_logged_in): ?>
                <a class="btn btn-success" href="<?= ROOT ?>/auth/login"><i class="fa-solid fa-arrow-right-to-bracket"></i> Login</a>
                <a class="btn btn-danger" href="<?= ROOT ?>/auth/signup"><i class="fa-solid fa-user-plus"></i> Signup</a>
            <?php else: ?>
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="text-white d-inline-block"><?= $_SESSION['USER']['name'] ?></span>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <li><a class="btn btn-danger dropdown-item" href="./dashboard.php"><i class="fa-solid fa-chart-line"></i> Dashboard</a></li>
                        <li><a class="btn btn-danger dropdown-item" href="<?= ROOT ?>/auth/logout"><i class="fa-solid fa-arrow-right-from-bracket"></i> Logout</a></li>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
    </div>
</nav>