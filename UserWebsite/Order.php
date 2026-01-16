<?php
session_start();

// Initialize cart if not already initialized
if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Function to add an item to the cart
function addToCart($name, $price, $quantity, $dineInTakeaway) {
    if ($quantity <= 0) return; // Validate quantity

    // Generate unique key for the cart item based on name and dine_in_takeaway
    $key = md5($name . $dineInTakeaway);

    // Check if the item is already in the cart
    if (isset($_SESSION['cart'][$key])) {
        // Item already exists, update quantity
        $_SESSION['cart'][$key]['quantity'] += $quantity;
    } else {
        // Item doesn't exist in cart, add new item
        $_SESSION['cart'][$key] = [
            'name' => htmlspecialchars($name), // Sanitize input
            'price' => $price,
            'quantity' => $quantity,
            'dine_in_takeaway' => $dineInTakeaway
        ];
    }
}

// Function to update the quantity of an item in the cart
function updateCartItemQuantity($key, $quantity) {
    if ($quantity <= 0) return; // Validate quantity

    if (isset($_SESSION['cart'][$key])) {
        // Update item quantity
        $_SESSION['cart'][$key]['quantity'] = $quantity;
    }
}

// Function to remove an item from the cart
function removeCartItem($key) {
    if (isset($_SESSION['cart'][$key])) {
        // Remove item from cart
        unset($_SESSION['cart'][$key]);
    }
}

// Clear all items from the cart
function clearCart() {
    $_SESSION['cart'] = [];
}

// Load cart items
function loadCart() {
    return isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
}

// Check if cart is empty
function isCartEmpty() {
    return empty($_SESSION['cart']);
}

// Function to calculate total cart amount
function calculateTotal() {
    $total = 0;
    foreach ($_SESSION['cart'] as $item) {
        $total += $item['price'] * $item['quantity'];
    }
    return number_format($total, 2);
}

// Handle actions (update/remove items/add item from modal)
if (isset($_GET['action'])) {
    $action = $_GET['action'];
    if ($action === 'update' && isset($_POST['key'], $_POST['quantity'])) {
        $key = htmlspecialchars($_POST['key']); // Sanitize input
        $quantity = (int)$_POST['quantity'];
        updateCartItemQuantity($key, $quantity);
    } elseif ($action === 'remove' && isset($_POST['key'])) {
        $key = htmlspecialchars($_POST['key']); // Sanitize input
        removeCartItem($key);
    } elseif ($action === 'add' && isset($_POST['name'], $_POST['price'], $_POST['quantity'], $_POST['dine_in_takeaway'])) {
        $name = htmlspecialchars($_POST['name']); // Sanitize input
        $price = (float)$_POST['price'];
        $quantity = (int)$_POST['quantity'];
        $dineInTakeaway = htmlspecialchars($_POST['dine_in_takeaway']); // Sanitize input
        addToCart($name, $price, $quantity, $dineInTakeaway);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
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
            background-color: #f1f1f1;
        }

        .cart-container {
            background-color: #fff;
            margin: 20px auto;
            max-width: 800px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow: hidden; /* Ensure contents don't overflow */
        }

        .cart {
            padding: 20px;
        }

        .table-responsive {
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 600px; /* Ensure the table has a minimum width */
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

        form {
            display: inline-block;
        }

        form button {
            border: none;
            background-color: #f44336;
            color: white;
            padding: 2px 2px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            cursor: pointer;
            border-radius: 3px;
            transition: background-color 0.3s ease;
        }

        form button:hover {
            background-color: #e53935;
        }

        form input[type="number"] {
            width: 50px;
            padding: 4px;
            text-align: center;
        }

        .total-row {
            font-weight: bold;
        }

        .empty-cart {
            font-style: italic;
            color: #777;
            margin-bottom: 10px;
        }

        .continue-shopping {
            margin-top: 10px;
        }

        .continue-shopping .button {
            border: none;
            background-color: green;
            color: white;
            padding: 8px 12px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            cursor: pointer;
            border-radius: 3px;
            transition: background-color 0.3s ease;
        }

        .continue-shopping button:hover {
            background-color: #45a049;
        }

        .check-out {
            margin-top: 10px;
            text-align: right;
        }

        .check-out .button {
            border: none;
            background-color: red;
            color: white;
            padding: 8px 12px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            cursor: pointer;
            border-radius: 3px;
            transition: background-color 0.3s ease;
        }

        .check-out button:hover {
            background-color: #ed2939;
        }

        /* Responsive Styles */
        @media (max-width: 600px) {
            .cart-container {
                margin: 10px;
            }
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
        <section class="cart-container">
            <section class="cart">
                <h1>Cart</h1>
                <?php if (!isCartEmpty()): ?>
                    <div class="table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th>Dine In / Take Away</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($_SESSION['cart'] as $key => $item): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($item['name']); ?></td>
                                        <td>RM <?php echo number_format($item['price'], 2); ?></td>
                                        <td>
                                            <form action="order.php?action=update" method="post">
                                                <input type="hidden" name="key" value="<?php echo htmlspecialchars($key); ?>">
                                                <input type="number" name="quantity" value="<?php echo htmlspecialchars($item['quantity']); ?>" min="1">
                                                <button type="submit">Update</button>
                                            </form>
                                        </td>
                                        <td>RM <?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                                        <td><?php echo htmlspecialchars($item['dine_in_takeaway']); ?></td>
                                        <td>
                                            <form action="order.php?action=remove" method="post">
                                                <input type="hidden" name="key" value="<?php echo htmlspecialchars($key); ?>">
                                                <button type="submit">Remove</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                <tr class="total-row">
                                    <td colspan="4"><strong>Total:</strong></td>
                                    <td colspan="2">RM <?php echo calculateTotal(); ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="continue-shopping">
                        <a href="Home.php"><button class="button">Continue Shopping</button></a>
                    </div>
                    <div class="check-out">
                        <a href="checkout.php"><button class="button">Checkout</button></a>
                    </div>
                <?php else: ?>
                    <p class="empty-cart">Your cart is empty.</p>
                    <div class="continue-shopping">
                        <a href="Home.php"><button class="button">Continue Shopping</button></a>
                    </div>
                <?php endif; ?>
            </section>
        </section>
    </main>