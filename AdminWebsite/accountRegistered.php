<?php
    include ("database.php");
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
            background: url('https://images.pexels.com/photos/1092730/pexels-photo-1092730.jpeg?cs=srgb&dl=pexels-janetrangdoan-1092730.jpg&fm=jpg') no-repeat center center fixed; /* Replace with the actual image path */
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

        .navbar .nav-links a {
            color: #fff;
            text-decoration: none;
            margin-left: 20px;
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
            text-align: center;
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
            border-radius: 10px;
        }
        .btn:hover {
            background-color: #45a049;
        }
        .error {
            color: red;
            display: none;
        }

    </style>
</head>
<body>
<div class="navbar">
        <div class="logo">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS8Aa4QEjqnv4nqpUQY_kQzeHuo1C609_FT4w&s" alt="INTI Logo"> <!-- Replace "logo.png" with the path to your logo image --><!-- You can remove this line if the image contains the college name -->
        </div>
</div>

<div class="wrapper">
    <div class="container">
        <img src="https://media.giphy.com/media/8GY3UiUjwKwhO/giphy.gif">
        <h2>Your Account is Created!</h2>
        <form action="accountRegistered.php" method="post">
            <button class="btn" name="submit" value ="Return To Login">Return To Login</button>
        </form>
    </div>
</div>
</body>
</html>
<?php
    if(isset($_POST["submit"] )){
        header("Location: Index.php");
    }
?>