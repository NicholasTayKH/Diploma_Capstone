<?php
    include("orderDatabase.php");
    include("database.php");
    require 'vendor/autoload.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    if(isset($_GET["profile"])){
        header("Location: profile.php");
    }

    $tab = isset($_GET["tab"]) ? '#' . $_GET["tab"] : '';
    
    if(isset($_GET["YesApprove"])) {
        
                $mail = new PHPMailer(true);
        
                            try {
                                $approveId = $_GET["YesApprove"];
                                $findUsers="SELECT * FROM orderTable WHERE orderid='$approveId'";
                                $resultFindUsers = mysqli_query($ordersconn, $findUsers);
                                if (mysqli_num_rows($resultFindUsers)>0) {
                                    // Fetch and display each row of the table
                                    while($rowUser = mysqli_fetch_assoc($resultFindUsers)) {
                                        $username = $rowUser['user'];
                                        $items = $rowUser['item'];
                                        $price = $rowUser['price'];
                                    }
                                    $findUserEmail="SELECT email FROM users WHERE user='$username'";
                                    $resultFindUserEmail = mysqli_query($conn,$findUserEmail);
                                    if (mysqli_num_rows($resultFindUserEmail)> 0){
                                        while($rowEmail = mysqli_fetch_assoc($resultFindUserEmail)) {
                                            $email = $rowEmail["email"];
                                        }
                                    }
                                }
                                // Server settings
                                $mail->isSMTP();
                                $mail->Host = 'smtp.gmail.com'; // Gmail SMTP server
                                $mail->SMTPAuth = true;
                                $mail->Username = 'nicholastay666@gmail.com'; // Your Gmail address
                                $mail->Password = 'rtnvrndgejjmksvb'; // Your Gmail password
                                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Encryption type (STARTTLS or SSL)
                                $mail->Port = 587; // TCP port to connect to
        
                                // Recipients
                                $mail->setFrom('nicholastay666@gmail.com', 'INTI Canteen'); // Your email and name
                                $mail->addAddress($email); // Recipient's email
        
                                // Content
                                $mail->isHTML(true);
                                $mail->Body = "Your Payment of Order number, " . $approveId . " had been approved by the admin.<br><br>Items:<br>" . nl2br($items) . "<br><br>Total price: RM".number_format($price,2)."<br><b><br>Thank you for your purchase.<br>Have a great day!";
        
                                $mail->send();
                                $approveSQL = "UPDATE orderTable SET statuss = 'Processing' WHERE orderid = '$approveId'";
                                $approveResult = mysqli_query($ordersconn, $approveSQL);
                                header("Location: order.php#pending");
                                exit();
                            } catch (Exception $e) {
                                echo "<script>alert('Mailer Error: {$mail->ErrorInfo} Message could not be sent. Please Restart your server and database');</script>";
                            }
         
    }
    
    if(isset($_GET["YesReject"])) {
        
                $mail = new PHPMailer(true);
        
                            try {
                                $rejectId = $_GET["YesReject"];
                                $findUsers="SELECT * FROM orderTable WHERE orderid='$rejectId'";
                                $resultFindUsers = mysqli_query($ordersconn, $findUsers);
                                if (mysqli_num_rows($resultFindUsers)>0) {
                                    // Fetch and display each row of the table
                                    while($rowUser = mysqli_fetch_assoc($resultFindUsers)) {
                                        $username = $rowUser['user'];
                                        $items = $rowUser['item'];
                                        $price = $rowUser['price'];
                                    }
                                    $findUserEmail="SELECT email FROM users WHERE user='$username'";
                                    $resultFindUserEmail = mysqli_query($conn,$findUserEmail);
                                    if (mysqli_num_rows($resultFindUserEmail)> 0){
                                        while($rowEmail = mysqli_fetch_assoc($resultFindUserEmail)) {
                                            $email = $rowEmail["email"];
                                        }
                                    }
                                }
                                // Server settings
                                $mail->isSMTP();
                                $mail->Host = 'smtp.gmail.com'; // Gmail SMTP server
                                $mail->SMTPAuth = true;
                                $mail->Username = 'nicholastay666@gmail.com'; // Your Gmail address
                                $mail->Password = 'rtnvrndgejjmksvb'; // Your Gmail password
                                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Encryption type (STARTTLS or SSL)
                                $mail->Port = 587; // TCP port to connect to
        
                                // Recipients
                                $mail->setFrom('nicholastay666@gmail.com', 'INTI Canteen'); // Your email and name
                                $mail->addAddress($email); // Recipient's email
        
                                // Content
                                $mail->isHTML(true);
                                $mail->Body = "Your Payment of Order number, " . $rejectId . " had been rejected by the admin.<br><br>Items:<br>" . nl2br($items) . "<br><br>Total price: RM".number_format($price,2)."<br><b><br>Please come to the counter to find out why.";
        
                                $mail->send();
                                
                                $rejectSQL = "UPDATE orderTable SET statuss = 'Cancelled' WHERE orderid = '$rejectId'";
                                $rejectResult = mysqli_query($ordersconn, $rejectSQL);
                                header("Location: order.php#pending");
                                exit();
                            } catch (Exception $e) {
                                echo "<script>alert('Mailer Error: {$mail->ErrorInfo} Message could not be sent. Please Restart your server and database');</script>";
                            }
            
    }
    
    if(isset($_GET["YesComplete"])) {
        
                $mail = new PHPMailer(true);
        
                            try {
                                $completeId = $_GET["YesComplete"];
                                $findUsers="SELECT user FROM orderTable WHERE orderid='$completeId'";
                                $resultFindUsers = mysqli_query($ordersconn, $findUsers);
                                if (mysqli_num_rows($resultFindUsers)>0) {
                                    // Fetch and display each row of the table
                                    while($rowUser = mysqli_fetch_assoc($resultFindUsers)) {
                                        $username = $rowUser['user'];
                                    }
                                    $findUserEmail="SELECT email FROM users WHERE user='$username'";
                                    $resultFindUserEmail = mysqli_query($conn,$findUserEmail);
                                    if (mysqli_num_rows($resultFindUserEmail)> 0){
                                        while($rowEmail = mysqli_fetch_assoc($resultFindUserEmail)) {
                                            $email = $rowEmail["email"];
                                        }
                                    }
                                }
                                // Server settings
                                $mail->isSMTP();
                                $mail->Host = 'smtp.gmail.com'; // Gmail SMTP server
                                $mail->SMTPAuth = true;
                                $mail->Username = 'nicholastay666@gmail.com'; // Your Gmail address
                                $mail->Password = 'rtnvrndgejjmksvb'; // Your Gmail password
                                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Encryption type (STARTTLS or SSL)
                                $mail->Port = 587; // TCP port to connect to
        
                                // Recipients
                                $mail->setFrom('nicholastay666@gmail.com', 'INTI Canteen'); // Your email and name
                                $mail->addAddress($email); // Recipient's email
        
                                // Content
                                $mail->isHTML(true);
                                $mail->Body = "Your Order number, " . $completeId . " is ready for pickup.";
        
                                $mail->send();
                                
                                $completeSQL = "UPDATE orderTable SET statuss = 'Completed' WHERE orderid = '$completeId'";
                                $completeResult = mysqli_query($ordersconn, $completeSQL);
                                header("Location: order.php#processing");
                                exit();
                            } catch (Exception $e) {
                                echo "<script>alert('Mailer Error: {$mail->ErrorInfo} Message could not be sent. Please Restart your server and database');</script>";
                            }
 
    }
    
    if(isset($_GET["YesCancel"])) {
        
                $mail = new PHPMailer(true);
        
                            try {
                                $cancelId = $_GET["YesCancel"];
                                $findUsers="SELECT user FROM orderTable WHERE orderid='$cancelId'";
                                $resultFindUsers = mysqli_query($ordersconn, $findUsers);
                                if (mysqli_num_rows($resultFindUsers)>0) {
                                    // Fetch and display each row of the table
                                    while($rowUser = mysqli_fetch_assoc($resultFindUsers)) {
                                        $username = $rowUser['user'];
                                    }
                                    $findUserEmail="SELECT email FROM users WHERE user='$username'";
                                    $resultFindUserEmail = mysqli_query($conn,$findUserEmail);
                                    if (mysqli_num_rows($resultFindUserEmail)> 0){
                                        while($rowEmail = mysqli_fetch_assoc($resultFindUserEmail)) {
                                            $email = $rowEmail["email"];
                                        }
                                    }
                                }
                                // Server settings
                                $mail->isSMTP();
                                $mail->Host = 'smtp.gmail.com'; // Gmail SMTP server
                                $mail->SMTPAuth = true;
                                $mail->Username = 'nicholastay666@gmail.com'; // Your Gmail address
                                $mail->Password = 'rtnvrndgejjmksvb'; // Your Gmail password
                                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Encryption type (STARTTLS or SSL)
                                $mail->Port = 587; // TCP port to connect to
        
                                // Recipients
                                $mail->setFrom('nicholastay666@gmail.com', 'INTI Canteen'); // Your email and name
                                $mail->addAddress($email); // Recipient's email
        
                                // Content
                                $mail->isHTML(true);
                                $mail->Body = "Your Order number, " . $cancelId . " had been cancelled by the admin. Please come to the counter to issue a refund.";
        
                                $mail->send();
                                
                                $cancelSQL = "UPDATE orderTable SET statuss = 'Cancelled' WHERE orderid = '$cancelId'";
                                $cancelResult = mysqli_query($ordersconn, $cancelSQL);
                                header("Location: order.php#processing");
                                exit();
                            } catch (Exception $e) {
                                echo "<script>alert('Mailer Error: {$mail->ErrorInfo} Message could not be sent. Please Restart your server and database');</script>";
                            }
            
    }
    if(isset($_GET["Yes"])){
        $total=0;
        $findTotal = "SELECT price FROM orderTable WHERE statuss = 'Completed'";
        $resultFindTotal = mysqli_query($ordersconn,$findTotal);
        if (mysqli_num_rows($resultFindTotal)> 0){
            while($rowFindTotal = mysqli_fetch_assoc($resultFindTotal)) {
                $total = $total + $rowFindTotal["price"];    
            }
        }
        $months = array('january', 'february', 'march', 'april', 'may', 'june', 'july','august','september','october','november','december');
        $getYear = "SELECT years FROM month WHERE years=(SELECT MAX(years) FROM month)";
        $resultGetYear = mysqli_query($ordersconn,$getYear);
        $rowGetYear = mysqli_fetch_assoc($resultGetYear);
        $maxYear = $rowGetYear["years"];
        if ($resultGetYear){
            $getMonth = "SELECT * FROM month WHERE years = $maxYear";
            $resultGetMonth = mysqli_query($ordersconn,$getMonth);
            if (mysqli_num_rows($resultGetMonth)> 0){
                $rowGetMonth = mysqli_fetch_assoc($resultGetMonth);
                if ($rowGetMonth[$months[11]]!==NULL){
                    $newMaxYear = $maxYear+1;
                    $newYear= "INSERT INTO month (years,january) VALUES ($newMaxYear,$total)";
                    $resultNewYear= mysqli_query($ordersconn,$newYear);
                    $newTableName = $months[11].$maxYear;
                    $dupTable = "CREATE TABLE $newTableName AS SELECT * FROM orderTable WHERE statuss = 'Completed'";
                    $resultDupTable = mysqli_query($ordersconn, $dupTable);
                    $deleteForNewYear = "DELETE FROM orderTable";
                    $resultDeleteForNewYear = mysqli_query($ordersconn,$deleteForNewYear);
                    header("Location: order.php#total");
                }
                else{
                    for ($i= 0; $i< 12; $i++){
                        if($rowGetMonth[$months[$i]]===NULL){
                            break;
                        }
                    }
                    $targetMonth = $months[$i];
                    $newMonth = "UPDATE month SET $targetMonth = $total WHERE years = (SELECT MAX(years) FROM month)";
                    $resultNewMonth = mysqli_query($ordersconn,$newMonth);
                    $newTableName2 = $months[$i].$maxYear;
                    $dupTable2 = "CREATE TABLE $newTableName2 AS SELECT * FROM orderTable WHERE statuss = 'Completed'";
                    $resultDupTable = mysqli_query($ordersconn, $dupTable2);
                    $deleteForNewMonth = "DELETE FROM orderTable";
                    $resultDeleteForNewMonth = mysqli_query($ordersconn,$deleteForNewMonth);
                    header("Location: order.php#total");
                }
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <style>
            body {
                font-family: Arial, sans-serif;
                background: url('https://images.pexels.com/photos/1640774/pexels-photo-1640774.jpeg') no-repeat center fixed;
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
                background: rgba(0, 0, 0, 0.2); /* Less dark overlay */
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
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
                height: 85%;
                margin: 0 auto;
                background-color: #fff;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                overflow: hidden; /* Ensure contents stay within the box */
                display: flex;
                flex-direction: column;
            }
            .bar {
                background-color: #92C4FF;
                height: 40px;
                display: flex;
                align-items: center;
                padding: 10px 30px;
                position: relative;
                z-index: 2;
                box-sizing: content-box;
            }
            .bar .box {
                background-color: #92C4FF;
                height: 36px;
                width: 12%;
                margin-right: 5px;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 10px 30px;
                position: relative;
                z-index: 2;
                box-sizing: content-box;
                cursor: pointer;
                transition: background-color 0.3s ease;
                border-radius: 8px;
            }
            .bar .box:hover {
                background-color: #0076ff;
            }
            .bar .box.active {
                background-color: #5fa9ff;
                border: 2px solid #0076ff;
                color: white;
            }
            .tab-content {
                display: none;
                padding: 20px;
                height: 100%;
                overflow-y: auto;
                flex: 1; /* Ensure it takes available space */
            }
            .tab-content.active {
                display: block; 
            }
            .container .itembox{
                background-color: white;
                width: auto;
                height: 85%;
                align-items: left;
                margin-top: 20px;
                margin-bottom:20px;
                margin-left: 20px;
                margin-right: 20px;
                z-index:3;
                overflow: scroll;
            }
            .table{
                z-index:2;
                width: 100%;
                border-collapse: collapse;
            }
            .table th, .table td{
                background-color: #fff;
                color: #000;
                padding: 10px;
                text-align: center;
                border: 1px solid #000;
            }
            .table th{
                background-color: #ececec;
            }
            .action-column {
                width: 100px; /* Adjust this value as needed */
            }
            .item-column {
                width: 300px; /* Adjust this value as needed */
            }

            .table th.action-column{
                width: 100px; /* Ensure this width is consistent with the header */
                text-align: center; /* Optional: Align text in the center */
            }
            .table th.item-column{
                max-width: 300px; /* Ensure this width is consistent with the header */
                text-align: center; /* Optional: Align text in the center */
            }
            .table td.action-column{
                width:100px;
                padding: 15px 5px;
                text-align: left;
            }
            .table td.item-column{
                max-width:300px;
                padding: 15px 5px;
                text-align: left;
            }
            .table td:hover{
                background-color: #ebecee;
            }
            .table .no-records td {
            text-align: center;
            vertical-align: middle;
            color: red; /* Optional: Change the color if needed */
            font-weight: bold;
            }
            .action {
            width: 15%;
            }
            .container {
                position: fixed;
                top: 100;
                left: 100;
                width: 90%;
                height: 80%;
                z-index: 1; /* Ensures the container is below itemBox */
            }
            
            .container .bar h3 {
                text-align: left;
                margin-left: 30px;
            }
            
            .container .itemBar {
                background-color: #D9D9D9;
                height: 20px;
                display: flex; 
                align-items: center;
                padding: 5px;
                position: relative;
                z-index: 2;
            }
            
            .container .itembox {
                background-color: white;
                width: auto;
                height: 93%;
                align-items: left;
                margin-top: 20px;
                margin-bottom: 20px;
                margin-left: 20px;
                margin-right: 20px;
                z-index: 3;
                overflow: scroll;
            }
            .btnTable{
                width: 40%;
                padding: 9px 0px;
                background-color: #007bff;
                border: none;
                color: white;
                border-radius: 4px;
                cursor: pointer;
                border: 1px solid #fff;
                margin-bottom:3px;
                margin-right: 3%;
            }

            .btnTableDelete{
                width: 40%;
                padding: 9px;
                background-color: red;
                border: none;
                color: white;
                border-radius: 4px;
                cursor: pointer;
                border: 1px solid #fff;
                margin-top:3px;

                margin-left: 3%;
            }
            .btnTable:hover,.btnTableDelete:hover{
                border: 1px solid #000;
                color: #000;
            }   
            #overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent background */
                display: flex;
                justify-content: center;
                align-items: center;
                z-index: 1000; /* Ensure it's on top of other content */
            }

            .overlay-content {
                width: auto;
                background-color: #92C4FF;
                max-width:75%;
                height:auto;
                padding: 5px;
                border-radius: 8px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                align-items: center;
                align-content: center;
                text-align:left;
                justify-content: space-between;
                border: 1px solid #0000FF;
            }

            /* Hidden class to toggle visibility */
            .hidden {
                display: none;
            }
            .container .bar .box2{
                background-color: #92C4FF;
                height: 40px;
                width: 15%;
                margin-right:0px;
                display: flex; 
                align-items: center;
                padding: 10px 0px;
                position: relative;
                z-index: 2;
                box-sizing: content-box;
                margin-left: 5%;
            }
            .button{
                background-color: #000;
                width: 100%;
                display: grid;
                padding: 8px;
                align-content: center;
                z-index:2;
                border-radius: 15px;
                text-align: center;
                border: 2px solid #000;
                font-size: 17px;
                color: #fff;
            }
            .button:hover{
                border: 2px solid #fff;
            }
            .overlay-content-reset {
                width: 40%;
                background-color: #92C4FF;
                max-width:75%;
                height:auto;
                padding: 5px;
                border-radius: 8px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                align-items: center;
                align-content: center;
                text-align:left;
                justify-content: space-between;
                border: 1px solid #0000FF;
                padding: 40px;
            }
            .delete-confirmation-confirm-btn{
                width: 40%;
                padding: 8px;
                background-color: #03c04a;
                border: none;
                color: white;
                border-radius: 4px;
                cursor: pointer;
                border:1px solid #FFC580;
                margin-top:10px;
                margin-left:10px;
                margin-right:50px;
            }

            .delete-confirmation-deny-btn{
                width: 40%;
                padding: 8px;
                background-color: #e3242b;
                border: none;
                color: white;
                border-radius: 4px;
                cursor: pointer;
                border:1px solid #FFC580;
                margin-top:10px;        
                margin-left:50px;
                margin-right:10px;
            }
            .delete-confirmation-confirm-btn:hover,.delete-confirmation-deny-btn:hover{
                border: 1px solid #000;
                color:black;
            }
        </style>
        <script>

            // JavaScript to toggle tabs
            function openTab(event, tabName) {
                var i, tabcontent, tabbuttons;
                tabcontent = document.getElementsByClassName("tab-content");
                for (i = 0; i < tabcontent.length; i++) {
                    tabcontent[i].style.display = "none";
                }
                tabbuttons = document.getElementsByClassName("box");
                for (i = 0; i < tabbuttons.length; i++) {
                    tabbuttons[i].classList.remove("active");
                }
                document.getElementById(tabName).style.display = "block";
                event.currentTarget.classList.add("active");
                
                // Update the URL hash to the current tab
                window.location.hash = tabName;
            }

            // Automatically open the tab based on the URL hash or open the first tab by default
            document.addEventListener('DOMContentLoaded', function() {
                var hash = window.location.hash.substring(1); // Remove the #
                var defaultTab = 'total';
                var tabToOpen = document.querySelector(`.bar .box[onclick*="${hash}"]`);
                
                if (tabToOpen) {
                    tabToOpen.click();
                } else {
                    document.querySelector(`.bar .box[onclick*="${defaultTab}"]`).click();
                }
            });
        </script>
    </head>
    <body>
        <div class="navbar">
            <div class="logo">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS8Aa4QEjqnv4nqpUQY_kQzeHuo1C609_FT4w&s" alt="INTI Logo">
            </div>
            <div class="nav-links">
                <a href="home.php">Home</a>
                <a href="item.php">Item</a>
                <a href="order.php">Order</a>
                <form class="box" action="order.php" method="get">
                    <input type="hidden" name="profile" value="1">
                    <input type="image" src="Images/logo4.png" width="25" height="25">
                </form>
            </div>
        </div>
        <div class="wrapper">
            <div class="container">
                <div class="bar">
                    <!-- Tab buttons -->
                    <div class="box" onclick="openTab(event, 'total')"><h4>Total Order</h4></div>
                    <div class="box" onclick="openTab(event, 'pending')"><h4>Pending Order</h4></div>
                    <div class="box" onclick="openTab(event, 'processing')"><h4>Processing Order</h4></div>
                    <div class="box" onclick="openTab(event, 'complete')"><h4>Completed Order</h4></div>
                    <div class="box" onclick="openTab(event, 'cancelled')"><h4>Cancelled Order</h4></div>
                    <form class="box2"action="order.php" method="get">
                        <button type="submit" class="button" name="resetOrder" value="resetOrder">Reset Orders</button>
                </form>
                </div>
                
                <div id="total" class="tab-content">
                <!-- Content for Total Order -->
                <div class="itembox">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>User</th>
                                <th class="item-column">Items</th>
                                <th>Price</th>
                                <th>Payment</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT orderid, user, item, image, price, statuss FROM orderTable";
                            $result = mysqli_query($ordersconn, $sql);
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    $color = "";
                                    switch ($row["statuss"]) {
                                        case "Completed":
                                            $color = "#03c04a";
                                            break;
                                        case "Processing":
                                            $color = "#fed420";
                                            break;
                                        case "Cancelled":
                                            $color = "red";
                                            break;
                                        case "Pending":
                                            $color = "orange";
                                            break;
                                    }
                                    echo "<tr>";
                                    echo "<td>" . $row["orderid"] . "</td>";
                                    echo "<td>" . $row["user"] . "</td>";
                                    echo "<td class =\"item-column\">" . nl2br($row["item"]) . "</td>";
                                    echo "<td>" . $row["price"] . "</td>";
                                    if(!empty($row["image"])) {
                                        echo "<td>
                                        <form action=\"order.php\" method=\"get\">
                                            <button type\"hidden\" name=\"imageEnlarge\" value=\"". $row["orderid"]."\">
                                            <img id=\"tableimg\" src=\"\" alt=\"TouchNGo\"></td>
                                            </button>
                                        </form>";
                                    } else {
                                        echo"<td>Pay At Counter</td>";
                                    }
                                    echo "<td style='color: $color;'>" . $row["statuss"] . "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr class='no-records'><td colspan='6'>No records found</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
                <div id="processing" class="tab-content">
                    <!-- Content for Processing Order -->
                    <div class="itembox">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>User</th>
                                <th class="item-column">Items</th>
                                <th>Price</th>
                                <th>Payment</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            $sql = "SELECT orderid, user, item, image, price, statuss FROM orderTable WHERE statuss='Processing'";
                            $result = mysqli_query($ordersconn,$sql);
                                // Check if there are any results and loop through the data
                                if ($result->num_rows > 0) {
                                    // Fetch and display each row of the table
                                        while($row = $result->fetch_assoc()) {
                                            $color = "";
                                        switch ($row["statuss"]) {
                                            case "Completed":
                                                $color = "#03c04a";
                                                break;
                                            case "Processing":
                                                $color = "#fed426";
                                                break;
                                            case "Cancelled":
                                                $color = "red";
                                                break;
                                            case "Pending":
                                                $color = "black";
                                                break;
                                        }
                                        echo "<tr>";
                                        echo "<td>" . $row["orderid"] . "</td>";
                                        echo "<td>" . $row["user"] . "</td>";
                                        echo "<td class =\"item-column\">" . nl2br($row["item"]) . "</td>";
                                        echo "<td>" . $row["price"] . "</td>";
                                        if(!empty($row["image"])) {
                                            echo "<td>
                                            <form action=\"order.php\" method=\"get\">
                                                <button type\"hidden\" name=\"imageEnlarge\" value=\"". $row["orderid"]."\">
                                                <img id=\"tableimg\" src=\"\" alt=\"TouchNGo\"></td>
                                                </button>
                                            </form>";
                                        } else {
                                            echo"<td>Pay At Counter</td>";
                                        }
                                        echo "<td style='color: $color;'>" . $row["statuss"] . "</td>";
                                        echo "<td>
                                            <form action=\"order.php\" method=\"get\">
                                                <button type=\"submit\" class=\"btnTable\" name=\"Complete\" value=".$row["orderid"].">Complete</button>
        
                                                <button type=\"submit\" class=\"btnTableDelete\" name=\"Cancel\" value=".$row["orderid"].">Cancel</button>
                                            </form>
                                            </td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr class='no-records'><td colspan='7'>No records found</td></tr>";
                                }
                                ?>
                        </tbody>
                    </table>
                    </div>
                </div>
                <div id="complete" class="tab-content">
                    <!-- Content for Successful Order -->
                    <div class="itembox">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>User</th>
                                <th class="item-column">Items</th>
                                <th>Price</th>
                                <th>Payment</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            $sql = "SELECT orderid, user, item, image, price, statuss FROM orderTable WHERE statuss='Completed'";
                            $result = mysqli_query($ordersconn,$sql);
                                // Check if there are any results and loop through the data
                                if ($result->num_rows > 0) {
                                    // Fetch and display each row of the table
                                    while($row = $result->fetch_assoc()) {
                                        $color = "";
                                    switch ($row["statuss"]) {
                                        case "Completed":
                                            $color = "#03c04a";
                                            break;
                                        case "Processing":
                                            $color = "yellow";
                                            break;
                                        case "Cancelled":
                                            $color = "red";
                                            break;
                                        case "Pending":
                                            $color = "black";
                                            break;
                                    }
                                        echo "<tr>";
                                        echo "<td>" . $row["orderid"] . "</td>";
                                        echo "<td>" . $row["user"] . "</td>";
                                        echo "<td class =\"item-column\">" . nl2br($row["item"]) . "</td>";
                                        echo "<td>" . $row["price"] . "</td>";
                                        if(!empty($row["image"])) {
                                            echo "<td>
                                            <form action=\"order.php\" method=\"get\">
                                                <button type\"hidden\" name=\"imageEnlarge\" value=\"". $row["orderid"]."\">
                                                <img id=\"tableimg\" src=\"\" alt=\"TouchNGo\"></td>
                                                </button>
                                            </form>";
                                        } else {
                                            echo"<td>Pay At Counter</td>";
                                        }
                                        echo "<td style='color: $color;'>" . $row["statuss"] . "</td>";
                                    }
                                } else {
                                    echo "<tr class='no-records'><td colspan='6'>No records found</td></tr>";
                                }
                                ?>
                        </tbody>
                    </table>
                    </div>
                </div>
                <div id="cancelled" class="tab-content">
                    <!-- Content for Cancelled Order -->
                    <div class="itembox">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>User</th>
                                <th class="item-column">Items</th>
                                <th>Price</th>
                                <th>Payment</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            $sql = "SELECT orderid, user, item, image, price, statuss FROM orderTable WHERE statuss='Cancelled'";
                            $result = mysqli_query($ordersconn,$sql);
                                // Check if there are any results and loop through the data
                                if ($result->num_rows > 0) {
                                    // Fetch and display each row of the table
                                    while($row = $result->fetch_assoc()) {
                                        $color = "";
                                        switch ($row["statuss"]) {
                                            case "Completed":
                                                $color = "#03c04a";
                                                break;
                                            case "Processing":
                                                $color = "yellow";
                                                break;
                                            case "Cancelled":
                                                $color = "red";
                                                break;
                                            case "Pending":
                                                $color = "black";
                                                break;
                                        }
                                        echo "<tr>";
                                        echo "<td>" . $row["orderid"] . "</td>";
                                        echo "<td>" . $row["user"] . "</td>";
                                        echo "<td class =\"item-column\">" . nl2br($row["item"]) . "</td>";
                                        echo "<td>" . $row["price"] . "</td>";
                                        if(!empty($row["image"])) {
                                            echo "<td>
                                            <form action=\"order.php\" method=\"get\">
                                                <button type\"hidden\" name=\"imageEnlarge\" value=\"". $row["orderid"]."\">
                                                <img id=\"tableimg\" src=\"\" alt=\"TouchNGo\"></td>
                                                </button>
                                            </form>";
                                        } else {
                                            echo"<td>Pay At Counter</td>";
                                        }
                                        echo "<td style='color: $color;'>" . $row["statuss"] . "</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr class='no-records'><td colspan='6'>No records found</td></tr>";
                                }
                                ?>
                        </tbody>
                    </table>
                    </div>
                </div>
                <div id="pending" class="tab-content">
                    <!-- Content for Processing Order -->
                    <div class="itembox">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>User</th>
                                <th class="item-column">Items</th>
                                <th>Price</th>
                                <th>Payment</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            $sql = "SELECT orderid, user, item, image, price, statuss FROM orderTable WHERE statuss='Pending'";
                            $result = mysqli_query($ordersconn,$sql);
                                // Check if there are any results and loop through the data
                                if ($result->num_rows > 0) {
                                    // Fetch and display each row of the table
                                    while($row = $result->fetch_assoc()) {
                                        $color = "";
                                        switch ($row["statuss"]) {
                                            case "Completed":
                                                $color = "#03c04a";
                                                break;
                                            case "Processing":
                                                $color = "yellow";
                                                break;
                                            case "Cancelled":
                                                $color = "red";
                                                break;
                                            case "Pending":
                                                $color = "orange";
                                                break;
                                        }
                                        echo "<tr>";
                                        echo "<td>" . $row["orderid"] . "</td>";
                                        echo "<td>" . $row["user"] . "</td>";
                                        echo "<td class =\"item-column\">" . nl2br($row["item"]) . "</td>";
                                        echo "<td>" . $row["price"] . "</td>";
                                        if(!empty($row["image"])) {
                                            echo "<td>
                                            <form action=\"order.php\" method=\"get\">
                                                <button type\"hidden\" name=\"imageEnlarge\" value=\"". $row["orderid"]."\">
                                                <img id=\"tableimg\" src=\"\" alt=\"TouchNGo\"></td>
                                                </button>
                                            </form>";
                                        } else {
                                            echo"<td>Pay At Counter</td>";
                                        }

                                        echo "<td style='color: $color;'>" . $row["statuss"] . "</td>";
                                        echo "<td>
                                            <form action=\"order.php\" method=\"get\">
                                                <button type=\"submit\" class=\"btnTable\" name=\"Approve\" value=".$row["orderid"].">Approve</button>
        
                                                <button type=\"submit\" class=\"btnTableDelete\" name=\"Reject\" value=".$row["orderid"].">Reject</button>
                                            </form>
                                            </td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr class='no-records'><td colspan='7'>No records found</td></tr>";
                                }

                                
                                ?>
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
        <?php
            if(isset($_GET["imageEnlarge"])){
            $id = $_GET["imageEnlarge"];
            $searchSql="SELECT image FROM orderTable WHERE orderid='$id'";
            $resultSearchSql= mysqli_query($ordersconn,$searchSql);
            if (mysqli_num_rows($resultSearchSql) > 0) {
                $rowSearch = mysqli_fetch_assoc($resultSearchSql);
            
                echo "
                <div id=\"overlay\" class=\"hidden\" onclick=\"history.back();\">
                    <div class=\"overlay-content\">
                        <img id=\"tableimg\" src=\"data:Images/png;base64,". base64_encode($rowSearch['image']) ."\" style=\"width:500px; height:800px;\">
                    </div>
                </div>
                ";
            }
            }

            if(isset($_GET["resetOrder"])){
                    echo "
                    <div id=\"overlay\" class=\"hidden\">    
                    <div class=\"overlay-content-reset\">
                        <form action=\"order.php\" method=\"get\">     
                            <h3>Do you want to Reset Order?</h3>
                            <br>
                            <br>
                            <button type=\"submit\" class=\"delete-confirmation-confirm-btn\" name=\"Yes\" value=\"1\">Yes</button>
                            <button type=\"button\" class=\"delete-confirmation-deny-btn\" name=\"No\" value=\"0\" onclick=\"history.back()\">No</button>
                        </form>
                    </div>
                </div>
                    ";
                
                }

                if(isset($_GET["Approve"])){
                    $id = $_GET["Approve"];
                    echo "
                    <div id=\"overlay\" class=\"hidden\">    
                    <div class=\"overlay-content-reset\">
                        <form action=\"order.php\" method=\"get\">     
                            <h3>Do you want to Approve Payment for Order,".$id."?</h3>
                            <br>
                            <br>
                            <button type=\"submit\" class=\"delete-confirmation-confirm-btn\" name=\"YesApprove\" value=\"".$id."\">Yes</button>
                            <button type=\"button\" class=\"delete-confirmation-deny-btn\" name=\"No\" value=\"0\" onclick=\"history.back()\">No</button>
                        </form>
                    </div>
                </div>
                    ";
                
                }
                if(isset($_GET["Reject"])){
                    $id = $_GET["Reject"];
                    echo "
                    <div id=\"overlay\" class=\"hidden\">    
                    <div class=\"overlay-content-reset\">
                        <form action=\"order.php\" method=\"get\">     
                            <h3>Do you want to Reject Payment for Order, ".$id."?</h3>
                            <br>
                            <br>
                            <button type=\"submit\" class=\"delete-confirmation-confirm-btn\" name=\"YesReject\" value=\"".$id."\">Yes</button>
                            <button type=\"button\" class=\"delete-confirmation-deny-btn\" name=\"No\" value=\"0\" onclick=\"history.back()\">No</button>
                        </form>
                    </div>
                </div>
                    ";
                
                }
                if(isset($_GET["Complete"])){
                    $id = $_GET["Complete"];
                    echo "
                    <div id=\"overlay\" class=\"hidden\">    
                    <div class=\"overlay-content-reset\">
                        <form action=\"order.php\" method=\"get\">     
                            <h3>Are you sure Order, ".$id." is Completed?</h3>
                            <br>
                            <br>
                            <button type=\"submit\" class=\"delete-confirmation-confirm-btn\" name=\"YesComplete\" value=\"".$id."\">Yes</button>
                            <button type=\"button\" class=\"delete-confirmation-deny-btn\" name=\"No\" value=\"0\" onclick=\"history.back()\">No</button>
                        </form>
                    </div>
                </div>
                    ";
                
                }
                if(isset($_GET["Cancel"])){
                    $id = $_GET["Cancel"];
                    echo "
                    <div id=\"overlay\" class=\"hidden\">    
                    <div class=\"overlay-content-reset\">
                        <form action=\"order.php\" method=\"get\">     
                            <h3>Do you want to Cancel Order, ".$id."?</h3>
                            <br>
                            <br>
                            <button type=\"submit\" class=\"delete-confirmation-confirm-btn\" name=\"YesCancel\" value=\"".$id."\">Yes</button>
                            <button type=\"button\" class=\"delete-confirmation-deny-btn\" name=\"No\" value=\"0\" onclick=\"history.back()\">No</button>
                        </form>
                    </div>
                </div>
                    ";
                
                }
        ?>
    </body>
</html>
