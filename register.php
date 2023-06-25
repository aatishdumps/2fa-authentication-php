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

        body {
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8f9fa;
        }

        .card,
        #alerts {
            width: 400px;
        }
    </style>
    <title>Register</title>
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center h-100 flex-column">
        <div id="alerts"></div>
        <div class="card shadow">
            <div class="card-body">
                <h2 class="card-title mb-4 text-center">Sign Up</h2>
                <form action="action.php" method="post" id="regForm">
                    <input type="hidden" name="action" value="register">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name">
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password">
                    </div>
                    <div class="mb-3">
                        <label for="cpassword" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="cpassword" name="cpassword" placeholder="Enter your password again">
                    </div>
                    <button type="submit" class="btn btn-primary">Sign Up</button>
                </form>
                <div class="text-center mt-3">
                    Already have an account? <a href="index.php" class="text-decoration-none">Sign In</a>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/jquery-3.7.0.min.js"></script>
    <script src="assets/bootstrap.bundle.min.js"></script>
    <script src="assets/scripts.js"></script>
</body>

</html>