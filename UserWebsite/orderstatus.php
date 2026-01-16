<?php
session_start();

// Load orders
function loadOrders() {
    return isset($_SESSION['orders']) ? $_SESSION['orders'] : [];
}

// Find specific order by ID
function findOrderById($orderId) {
    $orders = loadOrders();
    foreach ($orders as $order) {
        if ($order['orderId'] === $orderId) {
            return $order;
        }
    }
    return null;
}

$orders = loadOrders();
$orderId = isset($_GET['orderId']) ? $_GET['orderId'] : null;
$currentOrder = $orderId ? findOrderById($orderId) : null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Status</title>
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
        }

        .order-status {
            margin-bottom: 20px;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        td {
            vertical-align: middle;
        }

        .empty-orders {
            font-style: italic;
            color: #777;
            margin-bottom: 10px;
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
                <li><a href="Profile.php">Profile</a></li>
                <li><a href="Home.php">Continue Shopping</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="order-status">
            <h1>Order Status</h1>
                <h2>Order ID: <?php echo htmlspecialchars($currentOrder['orderId']); ?></h2>
                <p><strong>Date:</strong> <?php echo htmlspecialchars($currentOrder['timestamp']); ?></p>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Item</th>
                            <th>Date</th>
                            <th>Total</th>
                            <th>Dine In / Take Away</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php 
                        $getCurrent = "SELECT * FROM orderTable WHERE statuss='Processing'";
                        $resultGetCurrent = mysqli_query($ordersconn,$getCurrent);
                        if(mysqli_num_rows($resultGetCurrent) > 0) {
                            while($row = mysqli_fetch_assoc($resultGetCurrent)) {
                                echo"
                                <tr>
                                <td>".$row["orderid"]."</td>
                                <td>".$row["item"]."</td>
                                <td>".$row["timestamp"]."</td>
                                <td>".$row["price"]."</td>
                                <td>".$row["dine_in_takeaway"]."</td>
                                </tr>
                                ";
                            }
                        }
                        else{
                            echo"<p class=\"empty-orders\">No order found.</p>";
                        }
                        ?>
                    </tbody>
                </table>
        </section>

        <section class="order-history">
            <h1>Order History</h1>
                <table>
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Date</th>
                            <th>Total</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                        $getCurrent = "SELECT * FROM orderTable WHERE statuss='Completed'";
                        $resultGetCurrent = mysqli_query($ordersconn,$getCurrent);
                        if(mysqli_num_rows($resultGetCurrent) > 0) {
                            while($row = mysqli_fetch_assoc($resultGetCurrent)) {
                                echo"
                                <tr>
                                <td>".$row["orderid"]."</td>
                                <td>".$row["timestamp"]."</td>
                                <td>".$row["price"]."</td>
                                <td>".$row["item"]."</td>
                                </tr>
                                ";
                            }
                        }
                        else{
                            echo "<p class=\"empty-orders\">You have no orders.</p>";
                        }
                        ?>
                    </tbody>
                </table>
        </section>
    </main>
</body>
</html>