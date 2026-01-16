<?php
include("database.php");
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

error_reporting(E_ALL);
ini_set('display_errors', 1);

function generateOTP($length = 6) {
    return str_pad(mt_rand(0, pow(10, $length)-1), $length, '0', STR_PAD_LEFT);
}

session_start();

if (isset($_POST["submit"])) {
    if ($conn) {
        $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
        $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
        $password2 = filter_input(INPUT_POST, "confirmPassword", FILTER_SANITIZE_SPECIAL_CHARS);

        if(strlen($password) < 8){
            $error = "The password needs to be at least 8 characters.";
        }
        elseif(strpos($email, 'newinti.edu.my') === false){
            $error3="You need to use INTI email";
        }
        else {
            $sql = "SELECT * FROM users WHERE user = ?";
            $stmt = $conn->prepare($sql);

            if ($stmt) {
                $stmt->bind_param("s", $username);
                $stmt->execute();
                $stmt->store_result();

                if ($stmt->num_rows > 0) {
                    $error2 = "This username is taken.";
                } else {
                    $hash = password_hash($password, PASSWORD_DEFAULT);
                    $otp = generateOTP();
                    $_SESSION['otp'] = $otp;
                    $_SESSION['username'] = $username;
                    $_SESSION['email'] = $email;
                    $_SESSION['hash'] = $hash;

                    $mail = new PHPMailer(true);

                    try {
                        // Server settings
                        $mail->isSMTP();
                        $mail->Host = 'smtp.gmail.com'; // Gmail SMTP server
                        $mail->SMTPAuth = true;
                        $mail->Username = 'nicholastay666@gmail.com'; // Your Gmail address
                        $mail->Password = 'rtnvrndgejjmksvb'; // Your Gmail password
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Encryption type (STARTTLS or SSL)
                        $mail->Port = 587; // TCP port to connect to

                        // Recipients
                        $mail->setFrom('nicholastay666@gmail.com', 'INTI Canteen'); // Your email and name
                        $mail->addAddress($email); // Recipient's email

                        // Content
                        $mail->isHTML(true);
                        $mail->Subject = 'Your OTP Code';
                        $mail->Body = 'Your OTP code is: ' . $otp;

                        $mail->send();
                        echo 'OTP has been sent. Please check your email.';
                        header("Location: verify_otp.php");
                        exit();
                    } catch (Exception $e) {
                        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                    }
                }
                $stmt->close();
            } else {
                echo "Error preparing statement: " . $conn->error;
            }
        }
    } else {
        echo "Error: Could not connect to database";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('https://wallpapers.com/images/hd/food-4k-jx0j7rqea6yv9phh.jpg') no-repeat center fixed;
            background-size: cover;
            margin: 0;
            display: flex;
            height: 100vh;
            position: relative;
            flex-direction: column;
        }
        body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.2); /* Less dark overlay */
            z-index: 1;
        }
        .navbar {
            background-color: #000;
            color: #fff;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            position: relative;
            z-index: 2;
        }
        .navbar .logo {
            display: flex;
            align-items: center;
        }
        .navbar .logo img {
            height: 40px;
            margin-right: 10px;
        }
        .navbar .nav-links {
            display: flex;
            align-items: center;
        }
        .navbar .nav-links a {
            color: #fff;
            text-decoration: none;
            margin-left: 20px;
        }
        .navbar .nav-links a:hover {
            text-decoration: underline;
        }
        .wrapper {
            display: flex;
            width: 100%;
            position: relative;
            z-index: 2;
            flex: 1;
            align-items: center;
            justify-content: center;
        }
        .container {
            width: 500px;
            margin: 50px auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: left;
        }
        .container h2 {
            text-align: center;
        }
        input {
            width: calc(100% - 22px);
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .btn {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 4px;
        }
        .btn:hover {
            background-color: #45a049;
        }
        .error {
            color: red;
        }
        .error2 {
            color: red;
        }
    </style>
</head>
<body>
<div class="navbar">
    <div class="logo">
        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS8Aa4QEjqnv4nqpUQY_kQzeHuo1C609_FT4w&s" alt="INTI Logo">
    </div>
    <div class="nav-links">
        <a href="Login.php">Back to Login page</a>
    </div>
</div>
<div class="wrapper">
    <div class="container">
        <h2>Register</h2>
        <form id="registerForm" action="register.php" method="post">
            <input type="text" id="username" name="username" placeholder="Username" required>
            <?php if (isset($error2)) echo '<p class="error2">' . $error2 . '</p>'; ?>
            <input type="email" id="email" name="email" placeholder="Email Address" required>
            <?php
                if(isset($error3)){
                    echo '<p class="error"  >' . $error3 . '</p>';
                }
            ?>
            <input type="password" id="password" name="password" placeholder="Password" required>
            <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" required>
            <?php if (isset($error)) echo '<p class="error">' . $error . '</p>'; ?>
            <button type="submit" class="btn" name="submit">Submit</button>
        </form>
    </div>
</div>
</body>
</html>