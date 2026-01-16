<?php
if(isset($_GET["logout"])){
    header("Location: Index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <style>
            body {
                font-family: Arial, sans-serif;
                background: url('Images/LoginPageBackground.jpg') no-repeat center center fixed; /* Replace with the actual image path */
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
                border-radius: 50px;
                border: 2px solid #000;
                padding: 0px 5px;
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
                width: 90%;
                height:85%;
                margin: 0 auto;
                background-color: #fff; 
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);

            }

            .container .bar{
                background-color: #FFC580;
                height: 40px;
                display: flex; 
                align-items: center;
                padding: 10px 0px;
                position: relative;
                z-index: 2;
                box-sizing: content-box;
                justify-content: space-between; 
            }

            .box{
                background-color: #FFC580;
                height: 40px;
                width: 25%;
                margin-right:0px;
                display: flex; 
                align-items: center;
                padding: 10px 30px;
                position: relative;
                z-index: 2;
                box-sizing: content-box;
            }

            .button{
                background-color: #000;
                width: 40%;
                display: grid;
                padding: 8px;
                margin-left: 35px;
                align-content: center;
                z-index:2;
                border-radius: 20px;
                text-align: center;
                border: 2px solid #000;
                font-size: 17px;
                color: #fff;
            }

            .button:hover{
                border: 2px solid #fff;
            }

            .container .bar h3{
                text-align: left;
                margin-left:30px;
            }

            .container .itemBar{
                background-color: #D9D9D9;
                height: 20px;
                display: flex; 
                align-items: center;
                padding: 5px;
                position: relative;
                z-index: 2;
            }

            .container .itembox{
                background-color: lightgrey;
                width: auto;
                height: 615px;
                align-items: left;
                margin-top: 20px;
                margin-bottom:20px;
                margin-left: 20px;
                margin-right: 20px;
                z-index:3;
            }
            .table{
                z-index:2;
                width: 100%;
                border-collapse: collapse;
            }
            .table th, .table td{
                background-color: #000;
                color: #fff;
                padding: 10px;
                text-align: left;
                border: 1px solid #fff;
            }
            .table th{
                background-color: #333;
            }
            .table tr:nth-child(even){
                background-color: #444;
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
                        <input type="hidden" name="logout" value="1">
                        <input type="image" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQsIAHZZTBduj8-Y1ddXWbcpou_UIjkghNcUg&s\" width="25" height="25">
                    </form>
            </div>
        </div>
        <div class="wrapper">
            <div class="container">
                <div class="bar">
                    <h3>Items</h3>
                    <form class="box"action="item.php" method="get">
                        <button type="submit" class="button" name="editOption" value="editOption">Edit Option</button>
                        <button type="submit" class="button" name="addItem" value="addItem">Add Item</button>
                    </form>
                </div>
                <div class="itembox">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Items</th>
                                <th>Description</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Image</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>

                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>