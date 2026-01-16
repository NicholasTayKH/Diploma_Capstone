<?php
session_start();
include("database.php");

if (isset($_POST['verify'])) {
    $otp = filter_input(INPUT_POST, "adminotp", FILTER_SANITIZE_SPECIAL_CHARS);

    if ($otp === $_SESSION['otp']) {
        // OTP is correct, insert user into the database
        $username = $_SESSION['username'];
        $email = $_SESSION['email'];
        $hash = $_SESSION['hash'];

        $sql = "INSERT INTO admins (user, email, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $username, $email, $hash);

        if ($stmt->execute()) {
            echo "Registration successful!";
            // Clear session variables
            unset($_SESSION['otp']);
            unset($_SESSION['username']);
            unset($_SESSION['email']);
            unset($_SESSION['hash']);
            header("Location: accountRegistered.php");
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        $error = "Invalid OTP. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            height: 100vh;
            justify-content: center;
            align-items: center;
            background: #f0f0f0;
            background: url('https://png.pngtree.com/background/20230614/original/pngtree-variety-of-high-fiber-good-food-picture-image_3477354.jpg') no-repeat center fixed;
            background-size: cover;
        }
        .container {
            width: 400px;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .container h2 {
            text-align: center;
        }
        .container p{
            text-align:left;
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
    </style>
</head>
<body>
    <div class="container">
        <h2>Verify OTP</h2>
        <p>The OTP has been sent to your email.</p>
        <form method="post" action="admin_verify_otp.php">
            <input type="text" name="adminotp" placeholder="Enter OTP" value="" required>
            <?php if (isset($error)) echo '<p class="error">' . $error . '</p>'; ?>
            <button type="submit" class="btn" name="verify">Verify</button>
        </form>
    </div>
</body>
</html>
