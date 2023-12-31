<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('HTTP/1.1 400 Bad Request');
    exit;
}
require_once('./includes/conn.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require_once  __DIR__ . '/PHPMailer/Exception.php';
require_once  __DIR__ . '/PHPMailer/PHPMailer.php';
require_once  __DIR__ . '/PHPMailer/SMTP.php';

// mailer configuration
$mail = new PHPMailer(true);
// $mail->SMTPDebug = SMTP::DEBUG_SERVER;
$mail->SMTPDebug = 0;
$mail->isSMTP();
$mail->Host       = '';
$mail->SMTPAuth   = true;
$mail->Username   = '';
$mail->Password   = '';
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port       = 587;
$mail->setFrom('');

$action = $_POST['action'];
switch ($action) {
    case 'login':
        $email = trim($_POST['email']);
        $password = md5(trim($_POST['password']));
        $query = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
        $result = $conn->query($query);
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (!isset($user['token'])) {
                $status = 'twofactor';
                $message = "A 2FA code has been sent to your email address, please enter it in the below field.";
                $storedCode = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
                $user_id = $user['userid'];
                $name = $user['name'];
                $updateQuery = "UPDATE users SET two_fa_code = '$storedCode' WHERE userid = '$user_id'";
                $conn->query($updateQuery);
                try {
                    $mail->addAddress($email);
                    $mail->isHTML(false);
                    $mail->Subject = '2 Factor Authentication Code For Login';
                    $msg = "Dear $name,\n\nThank you for registering. Your 2FA code is:\n\n";
                    $msg .= "<h2>$storedCode</h2>\n\n";
                    $msg .= "Best regards,\nThe IWD Project Team";
                    $mail->Body = $msg;
                    $mail->send();
                } catch (Exception $e) {
                    // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
            } else {
                $status = 'error';
                $message = "Your account is not verified. Please verify your email or contact admin.";
            }
        } else {
            $status = 'error';
            $message = "Sorry, email or password is incorrect";
        }
        $response = array('status' => $status, 'message' => $message);
        break;

    case 'verify2fa':
        $code = trim($_POST['two_fa_code']);
        $email = trim($_POST['email']);
        $password = md5(trim($_POST['password']));
        $query = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
        $result = $conn->query($query);
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $storedCode = $user['two_fa_code'];
            if ($code == $storedCode) {
                $status = 'success';
                $message = "Logged in successfully! Please wait...";
                $user_id = $user['userid'];
                $_SESSION['loggedIn'] = true;
                $_SESSION['userid'] = $user_id;
                $updateQuery = "UPDATE users SET two_fa_code = 0 WHERE userid = '$user_id'";
                $conn->query($updateQuery);
            } else {
                // 2FA code is incorrect
                $status = 'error';
                $message = "Invalid 2FA code, please try again.";
            }
        } else {
            $status = 'error';
            $message = "Sorry, email or password is incorrect";
        }
        $response = array('status' => $status, 'message' => $message);
        break;
    case 'register':
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $cpassword = $_POST['cpassword'];
        // Server-side validation
        $errors = array();
        if (empty($name)) {
            $errors[] = "Name is required.";
        }
        if (empty($email)) {
            $errors[] = "Email is required.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email format.";
        } else {
            $xquery = "SELECT * FROM users WHERE email = '$email'";
            $xresult = $conn->query($xquery);
            if ($xresult->num_rows > 0) {
                $errors[] = "Email already exists.";
            }
        }

        if (empty($password)) {
            $errors[] = "Password is required.";
        } elseif (strlen($password) < 6) {
            $errors[] = "Password must be at least 6 characters long.";
        }

        if ($password !== $cpassword) {
            $errors[] = "Passwords do not match.";
        }

        if (count($errors) === 0) {
            $token = bin2hex(random_bytes(32));
            $hashedPassword = md5($password);
            $query = "INSERT INTO users (name, email, password, token) VALUES ('$name', '$email', '$hashedPassword', '$token')";
            if ($conn->query($query) === TRUE) {
                try {
                    $mail->addAddress($email);
                    $mail->isHTML(false);
                    $mail->Subject = 'Verify your email address';
                    $msg = "Dear $name,\n\nThank you for registering. Please click the following link to verify your email:\n\n";
                    $msg .= "https://example.com/verify.php?email=" . urlencode($email) . "&token=" . urlencode($token) . "\n\n";
                    $msg .= "If you did not register on our website, please ignore this email.\n\nBest regards,\nThe IWD Project Team";
                    $mail->Body = $msg;
                    $mail->send();
                } catch (Exception $e) {
                    // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
                $response = array('status' => 'success', 'message' => 'Registration successful! Please check your email to verify your account.');
            } else {
                $response = array('status' => 'error', 'message' => 'Registration failed. Please try again later.');
            }
        } else {
            $message = "";
            foreach ($errors as $error) {
                $message .= $error . '<br>';
            }
            $response = array('status' => 'error', 'message' => $message);
        }
        break;
}
// close connection
$conn->close();
header('Content-Type: application/json');
echo json_encode($response);
