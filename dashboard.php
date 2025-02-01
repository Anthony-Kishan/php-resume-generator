<?php
session_start();
include('./config.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: ./users/login.php');
    exit;
}

$userId = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT * FROM resumes WHERE user_id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$resumes = $stmt->get_result();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Resumes</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body>
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
                <?php while ($resume = $resumes->fetch_assoc()) { ?>
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
                            <a href="resume.php?id=<?php echo $resume['id']; ?>" target="_blank" class="btn btn-info"><i class="fa-solid fa-eye"></i></a>
                            <a href="download.php?id=<?php echo $resume['id']; ?>" class="btn btn-success"><i class="fa-solid fa-download"></i></a>
                            <a href="delete.php?id=<?php echo $resume['id']; ?>" class="btn btn-danger"><i class="fa-solid fa-trash"></i></a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>

</html>