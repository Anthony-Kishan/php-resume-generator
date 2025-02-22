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
                    html: '<?php echo implode("<br>", array_map("htmlspecialchars", $errors)); ?>'
                });
            });
        </script>
    <?php endif; ?>



    <!-- Sign-up form -->
    <div class="container mt-5">
        <h2>Sign Up</h2>
        <form method="POST">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control" id="username" name="username">
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email">
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
        </form>
    </div>


</body>

</html>