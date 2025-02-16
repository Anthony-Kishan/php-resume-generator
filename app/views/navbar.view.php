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