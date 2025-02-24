<?php
$is_logged_in = User::is_logged_in();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Resumes</title>
    <!-- Add the necessary CSS files -->
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/sweetalert2.min.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/navbar.css">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body>
    <?php include trim(__DIR__, 'resume') . 'navbar.view.php'; ?>

    <div class="container mt-5">
        <h2>Your Generated Resumes</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Template</th>
                    <th>Created Time</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($resumes as $resume) { ?>
                    <tr>
                        <td>
                            <?php
                            $personal_info = json_decode($resume['personal_info'], true);
                            echo htmlspecialchars($personal_info['fullName']);
                            ?>
                        </td>
                        <td><?php echo htmlspecialchars($resume['template_type']); ?></td>
                        <td><?php echo htmlspecialchars($resume['created_at']); ?></td>
                        <td>
                            <a href="../controllers/ResumeViewController.php?id=<?php echo base64_encode($resume['id']); ?>"
                                class="btn btn-info text-white">
                                <i class="fa-solid fa-eye"></i>
                            </a>

                            <a href="../controllers/DownloadController.php?id=<?php echo $resume['id']; ?>"
                                class="btn btn-success">
                                <i class="fa-solid fa-download"></i>
                            </a>

                            <a href="javascript:void(0)" data-id="<?php echo base64_encode($resume['id']); ?>"
                                class="btn btn-danger deleteBtn">
                                <i class="fa-solid fa-trash"></i>
                            </a>

                            <a href="../views/edit_resume.view.php?id=<?php echo base64_encode($resume['id']); ?>"
                                class="btn btn-warning">
                                <i class="fa-solid fa-pen text-white"></i>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Add the necessary JavaScript files -->
    <script src="<?= ROOT ?>/assets/js/jquery.min.js"></script>
    <script src="<?= ROOT ?>/assets/js/sweetalert2.min.js"></script>
    <script src="<?= ROOT ?>/assets/js/popper.min.js"></script>
    <script src="<?= ROOT ?>/assets/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function () {
            $(document).on('click', '.deleteBtn', function () {
                var deleteId = $(this).data('id');
                var row = $(this).closest('tr');

                $.ajax({
                    url: '../controllers/DeleteController.php',
                    method: 'POST',
                    data: { id: deleteId },
                    success: function (response) {
                        row.remove();
                    },
                    error: function () {
                        alert("An error occurred while deleting the resume.");
                    }
                });
            });
        });
    </script>

</body>

</html>