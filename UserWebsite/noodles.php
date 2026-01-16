
<?php
include("itemDatabase.php");

$sql="SELECT * FROM food WHERE foodcategory='Noodles'";
$result=mysqli_query($connn,$sql);

if ($result->num_rows > 0) {
    // Fetch and display each row of the table
    while($row = $result->fetch_assoc()) {

        echo "
            <div class='food-item'>
                <a href='#' class='food-item-link' 
                    
                   data-name='{$row['foodname']}' 
                   data-description='{$row['fooddescription']}' 
                   data-price='{$row['foodprice']}'>
                    <img src='{$row['foodimage']}' alt='{$row['foodname']}'>
                    <h4>{$row['foodname']}</h4>
                    <p>{$row['fooddescription']}</p>
                    <p class='price'>{$row['foodprice']}</p>
                </a>
            </div>
            ";
    }

}


?>





    






    



