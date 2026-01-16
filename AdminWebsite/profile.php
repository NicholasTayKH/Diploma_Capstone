<?php
include("database.php");
session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: Index.php");
    exit;
}

// Fetch logged-in user details from the database
$username = $_SESSION['username'];
$query = "SELECT * FROM admins WHERE user='$username'";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Error retrieving user information: " . mysqli_error($conn));
}

$user = mysqli_fetch_assoc($result);

// Handle logout
if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    session_destroy();
    header("Location: Index.php");
    exit;
}

// Handle password change
if (isset($_POST['change_password'])) {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if the current password matches
    if (password_verify($current_password, $user['password'])) {
        // Check if new password and confirm password match
        if ($new_password == $confirm_password) {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $update_query = "UPDATE admins SET password='$hashed_password' WHERE user='$username'";
            mysqli_query($conn, $update_query);
            echo "<script>alert('Password changed successfully!');</script>";
        } else {
            echo "<script>alert('New password and confirm password do not match.');</script>";
        }
    } else {
        echo "<script>alert('Current password is incorrect.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Profile</title>
    <link rel="stylesheet" href="styles.css">
    <style>
 /* General styles for the modal */
 
body {
                font-family: Arial, sans-serif;
                background: url('https://burst.shopifycdn.com/photos/flatlay-iron-skillet-with-meat-and-other-food.jpg?width=1000&format=pjpg&exif=0&iptc=0') no-repeat center center fixed; /* Replace with the actual image path */
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
            .navbar .nav-links{
                display: flex;
                align-items: center;
            }
            .navbar .nav-links a {
                color: #fff;
                text-decoration: none;
                margin-left: 30px;
            }
            .navbar .nav-links .box{
                background-color: #000;
                box-sizing: content-box;
                display: flex;
                position:relative;
                align-items: center;
                margin-left:30px;
                z-index:3;
                border-radius: 40px;
                border: 2px solid #000;
                padding: 5px 5px;
            }
            .navbar .nav-links .box img{
                height:30px;
            }
            .navbar .nav-links a:hover{
                text-decoration: underline;
            }
            .navbar .nav-links .box:hover{
                border: 2px solid #fff;
            }

.modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.4);
    justify-content: center;
    align-items: center;
}

.modal-content {
    background-color: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    width: 80%;
    max-width: 400px; /* Max width for larger screens */
    margin: 10px;
    text-align: left; /* Align text to the left */
    box-sizing: border-box; /* Ensure padding is included in the width */
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

form label {
    display: block;
    margin-top: 10px;
}

form input[type="password"] {
    width: 100%;
    padding: 10px;
    margin-top: 5px;
    box-sizing: border-box;
}

form button {
    width: 100%;
    padding: 10px;
    margin-top: 20px;
}



.profile-container {
    width:40%;
    max-width: 60%;
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    text-align: center;
    margin-top: 20px;
}

.profile-info {
    margin-bottom: 20px;
}

.profile-actions button {
    margin: 5px;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

#change-password {
    background-color: #4CAF50;
    color: white;
}

#logout {
    background-color: #f44336;
    color: white;
}
.wrapper{
                display: flex;
                width: 100%;
                position: relative;
                z-index: 2;
                flex: 1;
                align-items: center;
                justify-content: center;
            
}

    </style>
</head>
<body>
<div class="navbar">
            <div class="logo">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS8Aa4QEjqnv4nqpUQY_kQzeHuo1C609_FT4w&s" alt="INTI Logo"> <!-- Replace "logo.png" with the path to your logo image -->
            </div>
            <div class="nav-links">
                    <a href="home.php">Home</a>
                    <a href="item.php">Item</a>
                    <a href="order.php">Order</a>
                    
                    <form class="box" action="item.php" method="get">
                        <input type="hidden" name="profile" value="1">
                        <input type="image" src="Images/logo4.png" width="25" height="25">
                    </form>

            </div>
        </div>
<div class="wrapper">
<div class="profile-container">
    <h1>User Profile</h1>
    <div class="profile-info">
        <p><strong>Username:</strong> <?php echo htmlspecialchars($user['user']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
    </div>
    <div class="profile-actions">
        <button id="change-password">Change Password</button>
        <button id="logout" onclick="location.href='Index.php'">Log Out</button>
    </div>
</div>

<div id="password-modal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Change Password</h2>
        <form method="POST" action="profile.php">
            <label for="current-password">Current Password:</label>
            <input type="password" id="current-password" name="current_password" required>
            
            <label for="new-password">New Password:</label>
            <input type="password" id="new-password" name="new_password" required>
            
            <label for="confirm-password">Confirm New Password:</label>
            <input type="password" id="confirm-password" name="confirm_password" required>
            
            <button type="submit" name="change_password">Submit</button>
        </form>
    </div>
</div>
</div>
<script>
    document.getElementById('change-password').addEventListener('click', function() {
        document.getElementById('password-modal').style.display = 'flex';
    });

    document.getElementsByClassName('close')[0].addEventListener('click', function() {
        document.getElementById('password-modal').style.display = 'none';
    });

    window.onclick = function(event) {
        if (event.target == document.getElementById('password-modal')) {
            document.getElementById('password-modal').style.display = 'none';
        }
    };
</script>
</body>
</html>