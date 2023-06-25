<?php
require_once('./includes/conn.php');
if (isset($_GET['email']) && isset($_GET['token'])) {
    $email = $_GET['email'];
    $token = $_GET['token'];
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if ($token == $user['token']) {
            $status = 'success';
            $message = "Your account has been activated. Please <a href='index.php'>click here to login.</a>";
        } else {
            $status = 'error';
            $message = "The verification token is invalid. Please try again.";
        }
    } else {
        $status = 'error';
        $message = "The email is not associated with any account. Please try again.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/bootstrap.min.css">
    <style>
        html,
        body {
            height: 100%;
        }

        .card,
        #alerts {
            width: 400px;
        }
    </style>
    <title>Verify Email Address</title>
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center h-100 flex-column">
        <div id="alerts">
            <?php
            $color = $status ==  'success' ? 'success' : 'danger';
            echo '<div class="alert alert-' . $color . '>' . $message . '</div>';
            ?>
        </div>
    </div>
    <script src="assets/jquery-3.7.0.min.js"></script>
    <script src="assets/bootstrap.bundle.min.js"></script>
</body>

</html>