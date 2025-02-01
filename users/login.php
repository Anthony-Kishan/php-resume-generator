<?php include('../config.php'); session_start();?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
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
        <form action="login.php" method="POST">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>

    <?php
    // Login logic
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                header('Location: ../index.php?user_id=' . base64_encode($_SESSION['user_id'])); // Return to home page
                exit();
            } else {
                echo "<div class='alert alert-danger mt-3'>Incorrect password.</div>";
            }
        } else {
            echo "<div class='alert alert-danger mt-3'>User not found.</div>";
        }
    }
    ?>
</body>

</html>