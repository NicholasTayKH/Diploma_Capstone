<?php
    session_start();
    include("database.php");
    if (isset($_POST["submit"])) {
    $_SESSION["username"] = $_POST['username'];
    $_SESSION["password"] = $_POST['password'];
    $username = $_SESSION["username"];

    if($conn){
        $sql="SELECT * FROM users WHERE user = '$username'";
        $result = mysqli_query($conn, $sql);
        
        if(mysqli_num_rows($result)>0){
            while($row = mysqli_fetch_assoc($result)){
                $correct_username = $row["user"];
                $correct_password = $row["password"];
            };
            mysqli_close($conn);
            if ($_SESSION["username"] == $correct_username && password_verify($_SESSION["password"],$correct_password)) {
                header("Location: home.php");
            } 
                
            else {
                $error = "Invalid username or password";
            }
        }

        else {
            $error = "Invalid username or password";
        }
        
        }
        else{
            echo"<script type='text/javascript'>alert('Error: Could not connect to database');</script>";
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('https://wallpapers.com/images/hd/food-4k-3gsi5u6kjma5zkj0.jpg') no-repeat center center fixed; /* Replace with the actual image path */
            background-size: cover;
            margin: auto;
            display: flex;
            height: 100vh;
            position: relative;
            flex-direction: column;
            max-width: auto;
            max-height: auto;
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
            box-sizing: auto;
            color: #fff;
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
        .login-container {
            background-color: rgba(255, 255, 255, 0.8); /* Semi-transparent background */
            color: darkgrey;
            padding: 40px; /* Increased padding for a bigger box */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 400px; /* Increased width for a bigger box */
            text-align: center;
            border-radius: 15px; /* Rounded corners */
        }
        .login-container h2 {
            margin-bottom: 20px;
            color: black;
        }
        .login-container input {
            width: calc(100% - 22px);
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .login-container button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            border: none;
            color: white;
            border-radius: 4px;
            cursor: pointer;
        }
        .login-container button:hover {
            background-color: #0056b3;
        }
        .login-container a {
            display: block;
            margin-top: 10px;
            color: #007bff;
            text-decoration: none;
        }
        .login-container a:hover {
            text-decoration: underline;
        }
        .side-content {
            background-image: url('food_image.jpg'); /* Replace with the actual image path */
            background-size: cover;
            background-position: center;
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div class="logo">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS8Aa4QEjqnv4nqpUQY_kQzeHuo1C609_FT4w&s" alt="INTI Logo"> <!-- Replace "logo.png" with the path to your logo image -->
        </div>
    </div>
    <div class="wrapper">
        <div class="login-container">
            <h2>Login to your account</h2>
            <?php
            if (isset($error)) {
                echo '<p class="error"  >' . $error . '</p>';
            }
            ?>
            <form action="Login.php" method="post">
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit" name="submit">LOGIN</button>
            </form>
            <a href="register.php">Create an account</a>
        </div>
        <div class="side-content"></div>
    </div>
</body>
</html>