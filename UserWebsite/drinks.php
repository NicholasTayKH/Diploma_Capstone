
<?php
include("itemDatabase.php");

$sql="SELECT * FROM drink";
$result=mysqli_query($connn,$sql);

if ($result->num_rows > 0) {
    // Fetch and display each row of the table
    while($row = $result->fetch_assoc()) {

        echo "
            <div class='food-item'>
                <a href='#' class='food-item-link' 
                    
                   data-name='{$row['drinkname']}' 
                   data-description='{$row['drinkdescription']}' 
                   data-price='{$row['drinkprice']}'>
                    <img src='{$row['drinkimage']}' alt='{$row['drinkname']}'>
                    <h4>{$row['drinkname']}</h4>
                    <p>{$row['drinkdescription']}</p>
                    <p class='price'>{$row['drinkprice']}</p>
                </a>
            </div>
            ";
    }

}


?>





    






    



