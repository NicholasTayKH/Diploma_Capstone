<?php
    include("itemDatabase.php");
    include("optionDatabase.php");
    if($connn){
        $sql = "SELECT * FROM food";
        $result = mysqli_query($connn,$sql);
    }

    if(isset($_GET["editOption"])){
        header("Location: option.php");
    }

    if(isset($_GET["profile"])){
        header("Location: profile.php");
    }
    if(isset($_GET["confirmDelete"])){
        $id = urldecode($_GET['confirmDelete']);
        $deleteSql = "DELETE FROM food WHERE foodid = '$id'";
        $deleteResult=mysqli_query($connn,$deleteSql);
        if($deleteResult){
            header("Location: item.php");
        }
    }

    if(isset($_POST["confirmSave"])){
        $foodid = $_POST["confirmSave"];
        $foodname = $_POST["foodName"];
        $fooddesc = $_POST["foodDescription"];
        $foodcat = $_POST["cat"];
        $foodprice = $_POST["foodPrice"];
        $stock = $_POST["stock"];
        if(isset($_FILES['img']['tmp_name']) && !empty($_FILES['img']['tmp_name'])){
            $image = file_get_contents($_FILES['img']['tmp_name']);
            $imageData = mysqli_real_escape_string($connn, $image);
        }
        else{
            $imageData = NULL;
        }
        $editSql = "UPDATE food SET foodname='$foodname', foodcategory='$foodcat', fooddescription='$fooddesc', foodprice='$foodprice', foodimage='$imageData', foodstock='$stock' WHERE foodid='$foodid'";
        $editResult = mysqli_query($connn, $editSql);
        if($editResult){
            header("Location: item.php");
        }
    }

    if(isset($_POST["newConfirmSave"])){
        $newName = $_POST["newFoodName"];
        $newCat = $_POST["newCat"];
        $newDesc = $_POST["newFoodDescription"];
        $newPrice = $_POST["newFoodPrice"];
        if(isset($_FILES['img']['tmp_name']) && !empty($_FILES['img']['tmp_name'])){
            $image = file_get_contents($_FILES['img']['tmp_name']);
            $imageData = mysqli_real_escape_string($connn, $image);
        }
        else{
            $imageData = NULL;
        }
        $stock = $_POST['newStock'];

        $newSql = "INSERT INTO food(foodname,foodcategory,fooddescription,foodprice,foodimage,foodstock)
                    VALUES ('$newName','$newCat','$newDesc','$newPrice','$imageData','$stock')";
        $newResult=mysqli_query($connn,$newSql);
        if($newResult){
            header("Location: item.php");
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
                text-align: left;
                border: 1px solid #000;
            }
            .table th{
                background-color: #ececec;
            }
            .action-column {
                width: 150px; /* Adjust this value as needed */
            }
            .des-column {
                width: 200px; /* Adjust this value as needed */
            }
            .table th.action-column{
                width: 150px; /* Ensure this width is consistent with the header */
                text-align: center; /* Optional: Align text in the center */
            }
            .table th.des-column{
                max-width: 200px; /* Ensure this width is consistent with the header */
                text-align: center; /* Optional: Align text in the center */
            }

            .table td.action-column{
                width:150px;
                padding: 15px 5px;
                text-align: left;
            }
            .table td.des-column{
                max-width:200px;
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

            /* Overlay content styling */
            .overlay-content {
                background-color: #FFC580;
                width:40%;
                height:10%;
                padding: 40px;
                border-radius: 8px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                align-items: center;
                align-content: center;
                text-align:center;
                justify-content: space-between;
                border: 5px solid #ffb967;
            }

            .overlay-content-edit {
                background-color: #FFC580;
                width:40%;
                height:60%;
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
            .btnTable{
                width: 40%;
                padding: 9px;
                background-color: #007bff;
                border: none;
                color: white;
                border-radius: 4px;
                cursor: pointer;
                border: 1px solid #fff;
                margin-bottom:3px;
                margin-right: 5%;
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
                margin-left: 5%;
            }
            .btnTable:hover,.btnTableDelete:hover{
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
            /* Heading Style */

            .overlay-content-edit h2 {
                margin-bottom: 20px;
                font-family: 'Arial', sans-serif;
                color: #333;
            }

            /* Form Group Style */
            .form-group {
                margin-bottom: 15px;
                text-align: left;
            }
            .form-group select{
                width: calc(100% - 10px);
                padding: 8px;
                border: 1px solid #ddd;
                border-radius: 5px;
                box-sizing: border-box;
                transition: border 0.3s ease;
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
            .overlay-content-image {
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
            <div class="container">
                <div class="bar">
                    <h3>Items</h3>
                    <form class="box"action="item.php" method="get">
                        <button type="submit" class="button" name="editOption" value="editOption">Edit Mods</button>
                        <button type="submit" class="button" name="addItem" value="addItem">Add Item</button>
                    </form>
                </div>
                <div class="itembox">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Items</th>
                                <th>Category</th>
                                <th class="des-column">Description</th>
                                <th>Price</th>
                                <th>Image</th>
                                <th>Stock</th>
                                <th class="action-column">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                // Check if there are any results and loop through the data
                                if ($result->num_rows > 0) {
                                    // Fetch and display each row of the table
                                    while($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . $row["foodname"] . "</td>";
                                        echo "<td>" . $row["foodcategory"] . "</td>";
                                        echo "<td class\"des-column\">" . $row["fooddescription"] . "</td>";
                                        echo "<td>" . $row["foodprice"] . "</td>";
                                        if(!empty($row["foodimage"])) {
                                            echo "<td>
                                            <form action=\"item.php\" method=\"get\">
                                                <button type\"hidden\" name=\"imageEnlarge\" value=\"". $row["foodid"]."\">
                                                <img id=\"tableimg\" src=\"\" alt=\"Image\"></td>
                                                </button>
                                            </form>";
                                        } else {
                                            echo"<td>No Image</td>";
                                        }
                                        echo "
                                        <td>".$row["foodstock"]."</td>
                                        <td>
                                            <form action=\"item.php\" method=\"get\">
                                                <button type=\"submit\" class=\"btnTable\" name=\"edit\" value=".urlencode($row["foodid"]).">Edit</button>
        
                                                <button type=\"submit\" class=\"btnTableDelete\" name=\"delete\" value=".urlencode($row["foodid"]).">Delete</button>
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
        <?php
            if(isset($_GET["edit"])){
                $id = urldecode($_GET["edit"]);
                $findSql="SELECT * FROM food WHERE foodid = '$id'";
                $searchResult=mysqli_query($connn,$findSql);
                if(mysqli_num_rows($searchResult)>0){
                    while($row = mysqli_fetch_assoc($searchResult)){
                        $name=$row['foodname'];
                        $cat=$row['foodcategory'];
                        $desc=$row['fooddescription']; 
                        $image =$row['foodimage'];
                        $price = $row['foodprice'];
                        $stock = $row['foodstock'];
                    };
                }
                echo"
                <div id=\"overlay\" class=\"hidden\">
                    <div class=\"overlay-content-edit\">
                        <h2>Editing Food: ".$name."</h2>
                        <form action=\"item.php\" method=\"post\" enctype=\"multipart/form-data\">   
                            <div class=\"form-group\">
                            <label for=\"foodName\">Food Name</label>
                            <input type=\"text\" name=\"foodName\" value=\"".$name."\"><br>
                            </div>

                            <div class=\"form-group\">
                            <label for=\"cat\">Category</label>
                            <select name=\"cat\" placeholder=\"Please Select A Category\"required>";
                            if (!empty($cat)) {
                                // Show $cat as the first option
                                echo "<option value=\"$cat\" selected>$cat</option>";
                            } else {
                                // Show the default placeholder as the first option
                                echo "<option value=\"\" selected>Please Select A Category</option>";
                            }
                        
                            // Fetch categories from the database
                            $findCatSQL = "SELECT * FROM category";
                            $findCatSQLResult = mysqli_query($optionsconn, $findCatSQL);
                        
                            // Check if there are any results and loop through the data
                            if (mysqli_num_rows($findCatSQLResult) > 0) {
                                while ($row = mysqli_fetch_assoc($findCatSQLResult)) {
                                    // If $cat is set and matches the current row, skip it to avoid duplication
                                    if ($cat == $row["categorys"]) {
                                        continue;
                                    }
                                    // Render each category as an option
                                    echo "<option value=\"".$row["categorys"]."\">".$row["categorys"]."</option>";
                                }
                            }

                echo"       
                            </select>
                            </div>

                            <div class=\"form-group\">
                            <label for=\"foodDescription\">Description</label>
                            <input type=\"text\" name=\"foodDescription\" value=\"".$desc."\"><br>
                            </div>

                            <div class=\"form-group\">
                            <label for=\"foodPrice\">Price</label>
                            <input type=\"text\" name=\"foodPrice\" value=\"".$price."\"><br>
                            </div>
                            
                            <div class=\"form-group\">
                            <label for=\"foodImage\">Image Path</label>
                            <input type=\"file\" name=\"img\" id=\"file-input\" accept=\".png, .jpg\" value\"\">
                            </div>
                            <div class=\"form-group\">
                            <label for=\"stock\">Stock</label>
                            <select name=\"stock\" placeholder=\"Please Select A Stock\"required>";
                            if (!empty($stock)) {
                                // Show $cat as the first option
                                echo "<option value=\"$stock\" selected>$stock</option>";
                            } else {
                                // Show the default placeholder as the first option
                                echo "<option value=\"\" selected>Please Select An Option</option>";
                            }
                        
                            // Fetch categories from the database
                            $findStockSQL = "SELECT * FROM stock";
                            $findStockSQLResult = mysqli_query($optionsconn, $findStockSQL);
                        
                            // Check if there are any results and loop through the data
                            if (mysqli_num_rows($findStockSQLResult) > 0) {
                                while ($stockrow = mysqli_fetch_assoc($findStockSQLResult)) {
                                    // If $cat is set and matches the current row, skip it to avoid duplication
                                    if ($stock == $stockrow["stocks"]) {
                                        continue;
                                    }
                                    // Render each category as an option
                                    echo "<option value=\"".$stockrow["stocks"]."\">".$stockrow["stocks"]."</option>";
                                }
                            }
                            echo"</select>
                            </div>
                            <br>
                            <button type=\"submit\" class=\"delete-confirmation-confirm-btn\" name=\"confirmSave\" value=\"".$id."\">Save</button>
                            <button type=\"button\" class=\"delete-confirmation-deny-btn\" name=\"cancelSave\" value=\"".$id."\"onclick=\"history.back()\">Cancel</button>
                        </form>
                    </div>
                </div>
                ";
            }
            if(isset($_GET["delete"])){
                $id = urldecode($_GET['delete']);
                $findDeleteSql= "SELECT foodname FROM food WHERE foodid='$id'";
                $findSql=mysqli_query($connn,$findDeleteSql);
                $row = $findSql->fetch_assoc();
                echo "
                <div id=\"overlay\" class=\"hidden\">
                    <div class=\"overlay-content\">
                        <h2>Do you want to delete food: ".$row['foodname'].".</h2>
                        <form action=\"item.php\" method=\"get\">
                            <button type=\"submit\" class=\"delete-confirmation-confirm-btn\" name=\"confirmDelete\" value=".$id.">Yes</button>
                            <button type=\"submit\" class=\"delete-confirmation-deny-btn\" name=\"denyDelete\" value=".$id.">No</button>
                        </form>
                    </div>
                </div>
                ";
            }
            if(isset($_GET["cancelSave"])){
                exit();
            }

            if(isset($_GET["addItem"])){
                echo"
                <div id=\"overlay\" class=\"hidden\">
                    <div class=\"overlay-content-edit\">
                        <h2>Adding New Food: </h2>
                        <form action=\"item.php\" method=\"post\" enctype=\"multipart/form-data\">   
                            <div class=\"form-group\">
                            <label for=\"foodName\">Food Name</label>
                            <input type=\"text\" name=\"newFoodName\" value=\"\"><br>
                            </div>

                            <div class=\"form-group\">
                            <label for=\"cat\">Category</label>
                            <select name=\"newCat\" placeholder=\"Please Select A Category\"required>
                                <option value=\"\" selected>Please Select A Category</option>";
                $findCatSQL= "SELECT * FROM category";
                $findCatSQLResult = mysqli_query($optionsconn,$findCatSQL);
                if(mysqli_num_rows($findCatSQLResult)>0){
                    while($row = mysqli_fetch_assoc($findCatSQLResult)){
                        echo"   <option value=\"".$row["categorys"]."\">".$row["categorys"]."</option>";
                    };
                } 
                    
                echo"       </select>
                            </div>

                            <div class=\"form-group\">
                            <label for=\"foodDescription\">Description</label>
                            <input type=\"text\" name=\"newFoodDescription\" value=\"\"><br>
                            </div>

                            <div class=\"form-group\">
                            <label for=\"foodPrice\">Price</label>
                            <input type=\"text\" name=\"newFoodPrice\" value=\"\"><br>
                            </div>

                            <div class=\"form-group\">
                            <label for=\"foodImage\">Image Path</label>
                            <input type=\"file\" name=\"img\" id=\"file-input\" accept=\".png, .jpg\" onchange=\"loadFile(event)\">
                            </div>

                            <div class=\"form-group\">
                            <label for=\"newStock\">Stock</label>
                            <select name=\"newStock\" placeholder=\"Please Select A Stock\"required>
                                <option value=\"\" selected>Please Select An Option</option>";
                $findStockSQL= "SELECT * FROM stock";
                $findStockSQLResult = mysqli_query($optionsconn,$findStockSQL);
                if(mysqli_num_rows($findStockSQLResult)>0){
                    while($row = mysqli_fetch_assoc($findStockSQLResult)){
                        echo"   <option value=\"".$row["stocks"]."\">".$row["stocks"]."</option>";
                    };
                } 
                    
                            echo"
                            </select>
                            </div>
                            <br>
                            <button type=\"submit\" class=\"delete-confirmation-confirm-btn\" name=\"newConfirmSave\" >Save</button>
                            <button type=\"button\" class=\"delete-confirmation-deny-btn\" name=\"newCancelSave\" onclick=\"history.back()\">Cancel</button>
                        </form>
                    </div>
                </div>
                ";
            }
            if(isset($_GET["imageEnlarge"])){
                $id = $_GET["imageEnlarge"];
                $searchSql="SELECT foodimage FROM food WHERE foodid='$id'";
                $resultSearchSql= mysqli_query($connn,$searchSql);
                if (mysqli_num_rows($resultSearchSql) > 0) {
                    $rowSearch = mysqli_fetch_assoc($resultSearchSql);
                
                    echo "
                    <div id=\"overlay\" class=\"hidden\" onclick=\"history.back();\">
                        <div class=\"overlay-content-image\">
                            <img id=\"tableimg\" src=\"data:Images/png;base64,". base64_encode($rowSearch['foodimage']) ."\" style=\"width:700px; height:700px;\">
                        </div>
                    </div>
                    ";
                }
                }
            if(isset($_GET["newCancelSave"])){
            exit();
            }
        ?>
    </body>
</html> 