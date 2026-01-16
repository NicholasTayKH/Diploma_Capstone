<?php
session_start();

// Function to save the current cart as an order
function saveOrder() {
    if (!isset($_SESSION['orders'])) {
        $_SESSION['orders'] = [];
    }

    $orderId = uniqid(); // Generate a unique order ID
    $order = [
        'orderId' => $orderId,
        'items' => $_SESSION['cart'],
        'total' => calculateTotal(),
        'timestamp' => date('Y-m-d H:i:s'),
        'payment_method' => $_POST['payment_method'] // Assuming you capture payment method here
    ];

    $_SESSION['orders'][] = $order;

    // Clear the cart after saving the order
    clearCart();

    return $orderId;
}

// Function to calculate total cart amount
function calculateTotal() {
    $total = 0;
    foreach ($_SESSION['cart'] as $item) {
        $total += $item['price'] * $item['quantity'];
    }
    return number_format($total, 2);
}

// Function to clear all items from the cart
function clearCart() {
    $_SESSION['cart'] = [];
}

// Handle order confirmation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['payment_method'])) {
    $paymentMethod = $_POST['payment_method'];
    
    // Save the order
    saveOrder();
    
    // Redirect based on payment method
    if ($paymentMethod === 'tng') {
        header("Location: touchngo.php");
    } elseif ($paymentMethod === 'cash') {
        header("Location: cash.php");
    } else {
        // Handle invalid payment method (optional)
        // For example, redirect to an error page
        header("Location: error.php");
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
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

        .checkout {
            margin-bottom: 20px;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .responsive-table {
            width: 100%;
            border-collapse: collapse;
            display: block;
            overflow-x: auto;
        }

        .responsive-table th, .responsive-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
            min-width: 120px;
        }

        .responsive-table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .responsive-table td {
            vertical-align: middle;
        }

        .total-row {
            font-weight: bold;
        }

        .empty-cart {
            font-style: italic;
            color: #777;
            margin-bottom: 10px;
        }

        .payment-method {
            margin-top: 20px;
        }

        .payment-method label {
            display: block;
            margin-bottom: 10px;
        }

        .payment-method input {
            margin-right: 10px;
        }

        .confirm-order {
            margin-top: 20px;
        }

        .confirm-order button {
            background-color: #4caf50;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            border-radius: 3px;
            transition: background-color 0.3s ease;
        }

        .confirm-order button:hover {
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
                <li><a href="Profile.php">Profile</a></li>
                <li><a href="Order.php">Cart</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="checkout">
            <h1>Checkout</h1>
            <?php if (!empty($_SESSION['cart'])): ?>
                <div class="responsive-table">
                    <table>
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th>Dine In / Take Away</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        // Initialize an array to hold the combined strings
                        $combine = array();

                        // Initialize a variable to calculate the total price
                        $total = 0;

                        // Generate the table rows and populate the combine array
                        foreach ($_SESSION['cart'] as $item): 
                            echo '<tr>';
                            echo '<td>' . htmlspecialchars($item['name']) . '</td>';
                            echo '<td>RM ' . number_format($item['price'], 2) . '</td>';
                            echo '<td>' . htmlspecialchars($item['quantity']) . '</td>';
                            echo '<td>RM ' . number_format($item['price'] * $item['quantity'], 2) . '</td>';
                            echo '<td>' . htmlspecialchars($item['dine_in_takeaway']) . '</td>';
                            echo '</tr>';

                            // Combine name and quantity and add to the array
                            $combine[] = htmlspecialchars($item['name']) . " x " . htmlspecialchars($item['quantity']) ."(".htmlspecialchars($item['dine_in_takeaway']).")";

                            // Add to the total price
                            $total += $item['price'] * $item['quantity'];
                        endforeach;

                        // Convert the combine array into a single string, separated by commas
                        $_SESSION["combined"] = implode('\n', $combine);

                        // Store the total price in the session
                        $_SESSION["total"] = $total;
                        ?>
                            <tr class="total-row">
                                <td colspan="4"><strong>Total:</strong></td>
                                <td>RM <?php echo calculateTotal(); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <form action="Checkout.php" method="post">
                    <div class="payment-method">
                        <h2>Choose Payment Method</h2>
                        <label>
                            <input type="radio" name="payment_method" value="tng" required> TNG
                        </label>
                        <label>
                            <input type="radio" name="payment_method" value="cash" required> Cash
                        </label>
                    </div>
                    <div class="confirm-order">
                        <button type="submit">Confirm Order</button>
                    </div>
                </form>
            <?php else: ?>
                <p class="empty-cart">Your cart is empty.</p>
            <?php endif; ?>
        </section>
    </main>
</body>
</html>
