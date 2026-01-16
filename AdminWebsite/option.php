<?php
    include("optionDatabase.php");
    
    if(isset($_GET["profile"])){
        header("Location: profile.php");
    }

    if(isset($_GET["new_row"])){
        $newRow = $_GET["new_row"];
        $location = $_GET["enter"];
        $enhancedLocation = strtolower($location."s");
        $addNewValue = "INSERT INTO $location($enhancedLocation) VALUES('$newRow')";
        $addResult = mysqli_query($optionsconn,$addNewValue);
        header("Location: option.php?bubble-button=$location");
    }
    if(isset($_GET["delete"])){
        $deleteObject = $_GET["delete"];
        $locationDelete = $_GET["location"];
        $enhancedLocationDelete = $_GET["enhancedLocation"];
        $deleteSql = "DELETE FROM $locationDelete WHERE $enhancedLocationDelete = '$deleteObject'";
        $resultDelete = mysqli_query($optionsconn,$deleteSql);
        if($resultDelete){
            header("Location: option.php?bubble-button=$locationDelete");
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <style>
            body {
                font-family: Arial, sans-serif;
                background: url('https://images.pexels.com/photos/1640774/pexels-photo-1640774.jpeg') no-repeat center center fixed; /* Replace with the actual image path */
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

            .container .bar .box{
                background-color: #FFC580;
                height: 40px;
                width: 21%;
                display: flex;
                align-items: center;
                padding: 10px 0px;
                z-index: 2;
                align-items: right;
            }
            .container .bar .box .filterBox{
                align-items: right;
                text-align: right;
                background-color: #FFC580;
                height: 40px;
                width: 20%;
                display: flex; 
                padding: 10px 30px;
                z-index: 2;
            }
            .container .bar .box .buttonBox{
                background-color: #FFC580;
                height: 40px;
                width: 80%;
                display: flex; 
                align-items: right;
                padding: 10px 30px;
                z-index: 2;
            }
            .container .bar .box .filterBox .filter{
                margin-left:210px;
                height:35px;
                width:35px;
                border: 2px solid #FFC580;
                border-radius: 10px;
            }
            .container .bar .box .filterBox .filter:hover{
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
                height: 85%;
                align-items: left;
                margin-top: 20px;
                margin-bottom: 20px;
                margin-left: 20px;
                margin-right: 20px;
                z-index: 3;
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

            .table th.action-column{
                width: 100px; /* Ensure this width is consistent with the header */
                text-align: center; /* Optional: Align text in the center */
            }

            .table td.action-column{
                width:100px;
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
            .add-form {
                display: none;
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
                background-color: #FFC580;
                max-width:75%;
                height:auto;
                padding: 40px;
                border-radius: 8px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                align-items: center;
                align-content: center;
                text-align:left;
                justify-content: space-between;
                border: 5px solid #ffb967;
            }
            .overlay-content-add {
                background-color: #FFC580;
                width:40%;
                height:auto;
                padding: 40px;
                border-radius: 8px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                align-items: center;
                align-content: center;
                text-align:left;
                justify-content: space-between;
                border: 5px solid #ffb967;
            }


            /* Hidden class to toggle visibility */
            .hidden {
                display: none;
            }
            
            .form-group {
                margin-bottom: 15px;
                text-align: left;
            }

            .form-group label {
                display: block;
                margin-bottom: 5px;
                font-weight: bold;
                color: #333;
            }

            .form-group input {
                width: calc(100% - 10px);
                padding: 8px;
                border: 1px solid #ddd;
                border-radius: 5px;
                box-sizing: border-box;
                transition: border 0.3s ease;
            }

            .form-group input:focus {
                border-color: #007bff;
                outline: none;
            }
            .button-container {
                display: flex;
                gap: 20px;
            }

            .bubble-button {
                background-color: #fdaa48;
                border: 2px solid #f56416;
                height: 150px;
                width:150px;
                border-radius: 10px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                padding: 20px;
                font-size: 16px;
                cursor: pointer;
                transition: all 0.3s ease;
                margin-top: 50px;
                margin-left: 25px;
                margin-right: 25px;
            }

            .bubble-button:hover {
                background-color: #f56416;
                box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
            }

            .bubble-button:active {
                background-color: #dd571c;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
                transform: scale(0.95);
            }
            .btnTableEnter{
                width: 100%;
                padding: 9px;
                background-color: #03c04a;
                border: none;
                color: white;
                border-radius: 4px;
                cursor: pointer;
                border: 1px solid #fff;
                margin-bottom:3px;
            }
            .btnTable{
                width: 100%;
                padding: 9px;
                background-color: #007bff;
                border: none;
                color: white;
                border-radius: 4px;
                cursor: pointer;
                border: 1px solid #fff;
                margin-bottom:3px;
            }

            .btnTableDelete{
                width: 100%;
                padding: 9px;
                background-color: red;
                border: none;
                color: white;
                border-radius: 4px;
                cursor: pointer;
                border: 1px solid #fff;
                margin-top:3px;
            }
            .btnTable:hover,.btnTableDelete:hover,.btnTableEnter:hover{
                border: 1px solid #000;
                color: #000;
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

            .wrapper .bar1{
                background-color: #FFC580;
                width:90%;
                height: 40px;
                display: flex; 
                align-items: center;
                padding: 10px 20px;
                position: relative;
                z-index: 2;
                box-sizing: content-box;
                justify-content: space-between; 
            }

            .wrapper .bar1 .box1{
                background-color: #FFC580;
                height: 40px;
                width: 21%;
                display: flex;
                align-items: center;
                padding: 10px 0px;
                z-index: 2;
                align-items: right;
            }
            .wrapper .bar1 .box1 .filterBox1{
                align-items: right;
                text-align: right;
                background-color: #FFC580;
                height: 40px;
                width: 20%;
                display: flex; 
                padding: 10px 30px;
                z-index: 2;
            }
            .wrapper .bar1 .box1 .buttonBox1{
                background-color: #FFC580;
                height: 40px;
                width: 80%;
                display: flex; 
                align-items: right;
                padding: 10px 30px;
                z-index: 2;
            }
            .wrapper .bar1 .box1 .filterBox1 .filter1{
                margin-left:230px;
                height:35px;
                width:35px;
                border: 2px solid #FFC580;
                border-radius: 10px;
            }
            .wrapper .bar1 .box1 .filterBox1 .filter1:hover{
                border: 2px solid #fff;
            }
            
        </style>
        <script>
        // JavaScript to toggle the add form
        // JavaScript to toggle the add form
        function toggleAddForm() {
            var addForm = document.getElementById('addForm');
            var addLink = document.getElementById('addLink');
            if (addForm.style.display === 'none') {
                addForm.style.display = 'table-row';
                addLink.style.display = 'none';
            } else {
                addForm.style.display = 'none';
                addLink.style.display = 'table-row';
            }
        }
        </script>   
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
                    <form class="box" action="option.php" method="get">
                        <input type="hidden" name="profile" value="1">
                        <input type="image" src="Images/logo4.png" width="25" height="25">
                    </form>
            </div>
        </div>
        <?php
        if(!isset($_GET["bubble-button"]) && !isset($_GET["filter"])){
                echo "<div class=\"wrapper\">
                        <div class=\"bar1\">
                            <h3>   Modifications</h3>
                            <div class=\"box1\">
                            <form class=\"filterBox1\" action=\"option.php\" method=\"get\">
                                <input type=\"hidden\" name=\"filter\" value=\"1\">
                                <input class=\"filter1\" type=\"image\" src=\"Images/blacfilterIcon2.png\">
                            </form>
                            </div>
                        </div>
                </div>";
        }
                
                if(isset($_GET["filter"])){
                    echo"
                    <div id=\"overlay\" class=\"hidden\">
                    <div class=\"overlay-content\">
                    <h2>Filters: </h2>
                    <div class=\"button-container\">
                    <form action=\"option.php\" method=\"get\">
                    ";

                    echo"";
                    $sql="SHOW TABLES";
                    $result=mysqli_query($optionsconn,$sql);
                    while ($table = mysqli_fetch_array($result)) {
                        echo"            
                        <button class=\"bubble-button\" name=\"bubble-button\" value=". $table[0] .">". ucfirst($table[0]) ."</button>   
                    ";
                    }
                    echo"</form>";
                }
                ?>      
        
                <?php
                if(isset($_GET["bubble-button"])){
                    $location = $_GET["bubble-button"];
                    $enhancedLocation = strtolower($location."s");
                    $sqlTable = "SELECT * FROM $location";
                    $resultTable = mysqli_query($optionsconn,$sqlTable);
                    echo"
                     <div class=\"wrapper\">
                     <div class=\"container\">
                        <div class=\"bar\">
                            <h3>Modifications</h3>
                            <div class=\"box\">
                            <form class=\"filterBox\" action=\"option.php\" method=\"get\">
                                <input type=\"hidden\" name=\"filter\" value=\"1\">
                                <input class=\"filter\" type=\"image\" src=\"Images/blacfilterIcon2.png\">
                            </form>
                            </div>
                        </div>
                        
                    <div class=\"itembox\">
                        <table class=\"table\">
                    
                            <thead>
                                <tr>
                                    <th>".ucfirst($location)."</th>
                                    <th class=\"action\">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                    ";
                    // Check if there are any results and loop through the data
                    if ($resultTable->num_rows > 0) {
                        // Fetch and display each row of the table
                        while($row = $resultTable->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["$enhancedLocation"] . "</td>";
                            echo "<td class=\"action\">
                            <form action=\"option.php\" method=\"get\">
                                <input type=\"hidden\" name=\"location\" value=\"".$location."\">
                                <input type=\"hidden\" name=\"enhancedLocation\" value=\"".$enhancedLocation."\">
                                <button type=\"submit\" class=\"btnTableDelete\" name=\"delete\" value=\"".$row["$enhancedLocation"]."\">Delete</button>
                            </form>
                            </td>";
                            echo "</tr>";
                        }
                        
                    } 
                    echo"
                            <tr id=\"addLink\" class=\"centered\">
                                <td colspan=\"2\">
                                    <a href=\"#\" onclick=\"toggleAddForm(); return false;\">Add</a>
                                </td>   
                            </tr>
                            <tr id=\"addForm\" class=\"add-form\">
                                <form action=\"option.php\" method=\"get\">
                                    <td>
                                        <input type=\"text\" name=\"new_row\" placeholder=\"Enter new value\">
                                    </td>
                                    <td>
                                        <button type=\"submit\" class=\"btnTableEnter\" name=\"enter\" value=\"".$location."\">Enter</button>
                                        <button type=\"button\" class=\"btnTableDelete\" onclick=\"toggleAddForm();\">Cancel</button>
                                    </td>
                                </form>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                        </div>
                    </div>";
                }


                ?>     
            
    </body> 
</html> 