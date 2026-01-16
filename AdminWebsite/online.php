<?php
session_start();
// Database connection parameters
$servername = "localhost";
$username = "root";  // Default XAMPP username
$password = "";  // Default XAMPP password
$dbname = "ordersdb";

// Check if the form was submitted
if (isset($_POST['submit'])) {
    $target_dir = "uploads/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    $target_file = $target_dir . basename($_FILES["file"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    
    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["file"]["tmp_name"]);
    if ($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
    
    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }
    
    // Check file size (limit to 5MB)
    if ($_FILES["file"]["size"] > 5000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }
    
    // Allow certain file formats
    $allowedTypes = array("jpg", "png", "jpeg", "gif");
    if (!in_array($imageFileType, $allowedTypes)) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }
    
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
            echo "The file " . htmlspecialchars(basename($_FILES["file"]["name"])) . " has been uploaded.";

            // Read the uploaded file
            $imageData = file_get_contents($target_file);
            
            // Connect to the database
            $conn = new mysqli($servername, $username, $password, $dbname);
            
            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Prepare the SQL statement
            $stmt = $conn->prepare("INSERT INTO orders (image) VALUES (?)");
            $stmt->bind_param("b", $null); // 'b' for blob

            // Bind and execute the statement with the image data
            $stmt->send_long_data(0, $imageData);
            if ($stmt->execute()) {
                echo "Image has been uploaded to the database.";
            } else {
                echo "Error uploading image to the database: " . $stmt->error;
            }
            
            // Close the statement and connection
            $stmt->close();
            $conn->close();
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}


// Check if the order number is set
$orderNumber = isset($_GET['order_number']) ? (int)$_GET['order_number'] : null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f1f1f1;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: black;
            color: #fff;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo img {
            max-height: 50px;
            max-width: 100%;
        }

        nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
        }

        nav ul li {
            margin: 0 10px;
        }

        nav ul li a {
            text-decoration: none;
            color: #fff;
            font-weight: bold;
        }

        main {
            padding: 20px;
            background-color: #fff;
            margin: 20px auto;
            max-width: 800px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .thank-you {
            margin-top: 50px;
        }

        .thank-you h1 {
            font-size: 36px;
            color: #4caf50;
        }

        .thank-you p {
            font-size: 18px;
        }

        .order-number {
            font-size: 24px;
            color: #333;
            margin-top: 20px;
        }

        .back-home {
            margin-top: 20px;
        }

        .back-home button {
            background-color: #4caf50;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            border-radius: 3px;
            transition: background-color 0.3s ease;
        }

        .back-home button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS8Aa4QEjqnv4nqpUQY_kQzeHuo1C609_FT4w&s" alt="INTI International College Penang">
        </div>
        <nav>
            <ul>
                <li><a href="Login.php">Login</a></li>
                <li><a href="Order.php">Order</a></li>
                <li><a href="Home.php">Back</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="thank-you">
            <h1>Please Scan the QR code to pay the designated amount: blablabla</h1>
            <form>
                <img src="UserImages/TayKeanHaoTNG.jpg" alt = "Error Finding QR">
                <br>
                <input type="file" name="paymentProve">
            </form>
            <?php if ($orderNumber !== null): ?>
                <p class="order-number">Your Order Number: <?php echo $orderNumber; ?></p>
            <?php endif; ?>
            <div class="back-home">
                <button onclick="window.location.href='Home.php'">Back to Home</button>
            </div>
        </section>
    </main>
</body>
</html>
