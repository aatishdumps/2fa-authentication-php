<?php
session_start();
require_once('./includes/conn.php');
require_once('./includes/functions.php');
if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true) {
    $userid = $_SESSION['userid'];
    $query = "SELECT * FROM users where userid=$userid;";
    $run = $conn->query($query);
    $result = $run->fetch_assoc();
} else {
    die("User not logged in.");
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
    <title>Login</title>
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center h-100 flex-column">
        <div id="alerts"></div>
        <div class="card shadow">
            <div class="card-body">
                <h2 class="card-title mb-4 text-center">User Details</h2>
                <div class="table-responsive">
                    <table class="table align-middle">
                        <tbody>
                            <tr>
                                <td>UserID</td>
                                <td><?= $result['userid'] ?></td>
                            </tr>
                            <tr>
                                <td>Name</td>
                                <td><?= $result['name'] ?></td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td><?= $result['email'] ?></td>
                            </tr>
                            <tr>
                                <td>Logout</td>
                                <td><a href="logout.php" class="btn btn-danger btn-sm">Logout</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/jquery-3.7.0.min.js"></script>
    <script src="assets/bootstrap.bundle.min.js"></script>
</body>

</html>