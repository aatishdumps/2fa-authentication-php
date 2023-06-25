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
    <title>Login</title>
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center h-100 flex-column">
        <div id="alerts"></div>
        <div class="card shadow">
            <div class="card-body">
                <h2 class="card-title mb-4 text-center">Login</h2>
                <form action="action.php" method="post" id="logForm">
                    <input type="hidden" name="action" value="login">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter your username">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password">
                    </div>
                    <div class="mb-3 d-none" id="two_fa_div">
                        <label for="otp" class="form-label">2FA Code</label>
                        <input type="text" class="form-control" id="otp" name="otp" placeholder="Enter 2FA Code" onkeyup="this.value=this.value.replace(/[^\d]/,'')" maxlength="6">
                    </div>
                    <button type="submit" class="btn btn-primary">Login</button>
                </form>
                <div class="text-center mt-3">
                    Don't have an account? <a href="register.php" class="text-decoration-none">Sign Up</a>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/jquery-3.7.0.min.js"></script>
    <script src="assets/bootstrap.bundle.min.js"></script>
    <script src="assets/scripts.js"></script>
</body>

</html>