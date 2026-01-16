<?php
session_start();
include("orderDatabase.php");

if (isset($_POST["submit"])) {
    $image = file_get_contents($_FILES['img']['tmp_name']);
    $imageData = mysqli_real_escape_string($ordersconn, $image);

    $user = $_SESSION["username"];
    $itemName = $_SESSION["combined"];
    $price = $_SESSION["total"];
            $addSql = "INSERT INTO orderTable (user, item, image, price, statuss) 
            VALUES ('$user', '$itemName', '$imageData', '$price',  'Pending')";
         $resultaddSql = mysqli_query($ordersconn, $addSql);
        // Clear the cart after processing
        $_SESSION['cart'] = [];
    
        header("Location: Thankyou.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TNG Payment</title>
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

        .thank-you img {
            width: 50%;
            height: 100%;
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
            <li><a href="Home.php">Back to order</a></li>
        </ul>
    </nav>
</header>

<main>
    <section class="thank-you">
        <?php echo"<h1>Please Scan the QR code to pay the designated amount: RM ".number_format($_SESSION["total"],2)."</h1>";?>
        <form action="touchngo.php" method="post" enctype="multipart/form-data">
            <img src="UserImages/TayKeanHaoTNG.jpg" alt="Error Finding QR">
            <br>
            <input type="file" name="img" id="tmp_name" accept=".png, .jpg" required>
            <div class="back-home">
                <button type="submit" name="submit">Submit</button>
            </div>
        </form>
    </section>
</main>
</body>
</html>