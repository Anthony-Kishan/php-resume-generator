<!-- SIGNUP VIEW -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>

    <!-- Add the necessary CSS files -->
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/sweetalert2.min.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/signup.css">

    <!-- Add the necessary JavaScript files -->
    <script src="<?= ROOT ?>/assets/js/jquery.min.js"></script>
    <script src="<?= ROOT ?>/assets/js/bootstrap.min.js"></script>
    <script src="<?= ROOT ?>/assets/js/sweetalert2.min.js"></script>
</head>

<body>
    <!-- Bootstrap Modal -->
    <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="errorModalLabel">Error</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul>
                        <?php if (isset($errors) && is_array($errors)): ?>
                            <?php foreach ($errors as $error): ?>
                                <li><?php echo htmlspecialchars($error); ?></li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Trigger modal if needed -->
    <?php if (isset($showModal) && $showModal && isset($errors) && is_array($errors)): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    html: '<?php echo implode("<br>", array_map(function ($error) {
                        return "<li>" . htmlspecialchars($error) . "</li>";
                    }, $errors)); ?>'
                });
            });
        </script>
    <?php endif; ?>


    <!-- Sign-up form -->
    <div class="container mt-5">
        <h2>Sign Up</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Username:</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" class="form-control" id="password" name="password"
                    placeholder="Enter your password">
            </div>
            <div class="mb-3">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="terms" name="terms">
                    <label class="form-check-label" for="terms">I agree to the <span class="terms">terms and
                            conditions</span></label>
                </div>
            </div>
            <button type="submit" class="btn">Sign Up</button>
        </form>
        <p class="footer-text">Already have an account? <a href="<?= ROOT ?>/auth/login">Login</a></p>
    </div>
</body>

</html>