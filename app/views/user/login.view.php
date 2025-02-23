<!-- LOGIN VIEW -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- Add the necessary CSS files -->
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/signup.css">

    <!-- Add the necessary JavaScript files -->
    <script src="<?= ROOT ?>/assets/js/jquery.min.js"></script>
    <script src="<?= ROOT ?>/assets/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container mt-5">
        <h2>Login</h2>

        <?php
        if (isset($_SESSION['message'])) {
            echo "<div class='alert alert-success mt-3'>" . $_SESSION['message'] . "</div>";
            unset($_SESSION['message']);
        }
        ?>
        
        <!-- Trigger modal if needed -->
        <?php if (isset($showModal) && $showModal && isset($errors) && is_array($errors)): ?>
            <div class='alert alert-danger mt-3'>
                <?php echo implode("<br>", array_map(function ($error) {
                    return "<li>" . htmlspecialchars($error) . "</li>";
                }, $errors)); ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" class="form-control" id="password" name="password"
                    placeholder="Enter your password">
            </div>
            <button type="submit" class="btn">Login</button>
        </form>

        <p class="footer-text">Don't have an account? <a href="<?= ROOT ?>/auth/signup">Sign Up</a></p>
    </div>
</body>

</html>