<?php
include("database.php");
include("itemDatabase.php");
include("optionDatabase.php");
if (isset($_POST["submit"])) {
    header("Location: Home.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INTI International College Penang - How to Order</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .cart-link {
            background-color: #4caf50;
            color: white;
            padding: 8px 12px;
            text-decoration: none;
            border-radius: 3px;
            transition: background-color 0.3s ease;
        }

        .cart-link:hover {
            background-color: #45a049;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: black;
            padding: 10px 20px;
            border-bottom: 1px solid #ccc;
        }

        .logo img {
            max-height: 50px;
            max-width: 100%;
        }

        nav ul {
            list-style: none;
            display: flex;
            margin: 0;
            padding: 0;
        }

        nav ul li {
            margin: 0 10px;
        }

        nav ul li a {
            text-decoration: none;
            color: white;
        }
        .how-to-order {
            text-align: center;
            padding: 20px;
            background-color: white;
            background: url('https://i.pinimg.com/originals/a6/3d/46/a63d462685a63f8aa42ec02dbafc0b1c.gif') no-repeat center center fixed;
            background-size: cover;
        }

        .how-to-order h1 {
            font-size: 3em; /* Increase the font size */
            font-weight: bold; /* Make the text bold */
            color: white; /* White text color */
            text-align: center; /* Center align the text */
            margin: 20px 0; /* Add some margin */
            text-shadow: 
                -2px -2px 0 #000,  
                2px -2px 0 #000,
                -2px  2px 0 #000,
                2px  2px 0 #000,
                -2px  0px 0 #000,
                2px  0px 0 #000,
                0px -2px 0 #000,
                0px  2px 0 #000,
                0 0 10px rgba(255, 255, 255, 0.7), /* Outer glow */
                0 0 20px rgba(255, 255, 255, 0.5), /* Outer glow */
                0 0 30px rgba(255, 255, 255, 0.3); /* Outer glow */
        }

        .steps {
            display: flex;
            justify-content: center;
            margin-top: 20px;
            flex-wrap: wrap;
            align-items: center;
        }

        .step {
            margin: 0 20px;
            text-align: center;
            position: relative;
            width: 100px;
            height: 100px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .step span {
            display: block;
            font-size: 18px;
            font-weight: bold;
            color: white;
            position: relative;
            z-index: 1;
            margin-bottom: 5px; /* Add some space between number and text */
        }

        .step p {
            margin: 0;
            color: white;
            position: relative;
            z-index: 1;
            font-size: 14px;
        }

        .step::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100px;
            height: 100px;
            background-color: black;
            border-radius: 50%;
            z-index: 0;
        }


        .step:last-child::after {
            content: '';
        }


        .food-menu {
            padding: 20px;
        }

        .food-category {
            margin-bottom: 20px;
        }

        .food-category h3 {
            background-color: #000;
            color: #fff;
            padding: 10px;
            margin: 0;
        }

        .food-items {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .food-item-link {
            text-decoration: none;
            color: inherit;
            display: block;
            flex: 1 1 calc(33.333% - 20px);
            box-sizing: border-box;
            padding: 10px;
            margin: 10px;
            border: 1px solid #ccc;
            text-align: center;
            cursor: pointer;
        }

        .food-item {
            flex: 1 1 calc(33.333% - 20px);
            box-sizing: border-box;
            padding: 10px;
            margin: 10px;
            border: 1px solid #ccc;
            text-align: center;
        }

        .food-item img {
            max-width: 100%;
            max-height: 200px;
            background-color: #eaeaea;
        }

        .food-item h4 {
            margin: 10px 0 5px;
        }

        .food-item p {
            margin: 0 0 10px;
        }

        .food-item .price {
            font-weight: bold;
        }

        .food-item:hover {
            background-color: #f0f0f0;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border-radius: 10px;
            width: 90%;
            max-width: 400px;
        }

        .modal-content h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .modal-content label {
            display: block;
            margin-top: 10px;
            
        }

        .modal-content select,
        .modal-content input[type="number"] {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .quantity-selector {
            display: flex;
            align-items: center;
            margin-top: 10px;
            justify-content: space-between;
        }

        .quantity-selector button {
            width: 40px;
            height: 30px;
            text-align: center;
            vertical-align: middle;
            border: 1px solid #ccc;
            background-color: #f0f0f0;
            cursor: pointer;
            border-radius: 50%;
        }

        .quantity-selector input {
            width: 50px;
            text-align: center;
            margin: 0 10px;
            border: 1px solid #ccc;
            padding: 5px;
        }

        .quantity-selector #decrease-quantity {
            background-color: darkred;
            color: white;
        }

        .quantity-selector #increase-quantity {
            background-color: red;
            color: white;
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

        .modal-content button[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4caf50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 30px;

        }

        .modal-content button[type="submit"]:hover {
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

    <section class="how-to-order">
        <h1>HOW TO ORDER</h1>
        <div class="steps">
            <div class="step">
                <span>1</span>
                <p>Select Food</p>
            </div>
            <div class="step">
                <span>2</span>
                <p>Choose Requirement</p>
            </div>
            <div class="step">
                <span>3</span>
                <p>Payment</p>
            </div>
        </div>
    </section>

    <?php 
    $getCategory = "SELECT * FROM category";
    $resultGetCategory = mysqli_query($optionsconn,$getCategory);
    if(mysqli_num_rows($resultGetCategory) > 0) {
        while($row = mysqli_fetch_assoc($resultGetCategory)) {
            $tempCat = $row["categorys"];
            $getItem = "SELECT * FROM food WHERE foodcategory='$tempCat' AND foodstock = 'In Stock'";
            $resultGetItem = mysqli_query($connn,$getItem);
            echo"<section class=\"food-menu\">
                        <div class=\"food-category\">
                            <h3>".$row["categorys"]."</h3>
                            ";
            if(mysqli_num_rows($resultGetItem) > 0) {
                while($itemrow = mysqli_fetch_assoc($resultGetItem)) {
                echo"
                            <div class=\"food-items\">
                            <a href=\"#\" class=\"food-item-link\" 
                            data-name=\"".$itemrow["foodname"]."\" 
                            data-description=\"".$itemrow["fooddescription"]."\" 
                            data-price=\"".$itemrow["foodprice"]."\">
                                <img src=\"data:Images/png;base64,". base64_encode($itemrow['foodimage']) ."\" alt=\"".$itemrow["foodname"]."\" style=\"width:300px; height:300px;\">
                                <h4>".$itemrow["foodname"]."</h4>
                                <p>".$itemrow["fooddescription"]."</p>
                                <p class=\"price\">RM ".number_format($itemrow["foodprice"],2)."</p>
                            </a>
                            </div>
                       ";
            }
        }
        echo" </div>
                    </section>";
    }
}
    ?>
</main>

<div id="addToCartModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Add item to cart?</h2>
        <form action="order.php?action=add" method="post">
            <input type="hidden" id="modal-product-name" name="name">
            <input type="hidden" id="modal-product-price" name="price">
            <div class="quantity-selector">
                <button type="button" id="decrease-quantity">-</button>
                <input type="number" id="modal-product-quantity" name="quantity" min="1" value="1">
                <button type="button" id="increase-quantity">+</button>
            </div>
            <label for="modal-dine-in-takeaway">Dine In or Take Away:</label>
            <select id="modal-dine-in-takeaway" name="dine_in_takeaway">
                <option value="Dine In" selected>Dine In</option>
                <option value="Take Away">Take Away</option>
            </select>
            <button type="submit">Add to Cart</button>
        </form>
    </div>
</div>

<script>
    // Get the modal
    var modal = document.getElementById("addToCartModal");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // Function to open the modal and populate with item details
    function openPopup(element) {
        var name = element.getAttribute("data-name");
        var price = element.getAttribute("data-price");

        document.getElementById("modal-product-name").value = name;
        document.getElementById("modal-product-price").value = price;
        document.getElementById("modal-product-quantity").value = 1;
        
        modal.style.display = "block";
    }

    // Add event listeners to food item links
    document.querySelectorAll('.food-item-link').forEach(item => {
        item.addEventListener('click', function(event) {
            event.preventDefault();
            openPopup(item);
        });
    });

    // Close modal function when user clicks on <span> (x)
    span.onclick = function() {
        modal.style.display = "none";
    }

    // Close modal function when user clicks anywhere outside of the modal
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    // Quantity increment and decrement functionality
    var quantityInput = document.getElementById("modal-product-quantity");
    document.getElementById("decrease-quantity").onclick = function() {
        var currentValue = parseInt(quantityInput.value);
        if (currentValue > 1) {
            quantityInput.value = currentValue - 1;
        }
    }

    document.getElementById("increase-quantity").onclick = function() {
        var currentValue = parseInt(quantityInput.value);
        quantityInput.value = currentValue + 1;
    }
</script>
</body>
</html>