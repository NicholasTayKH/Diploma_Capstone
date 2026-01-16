<?php 
include("itemDatabase.php"); 
include("orderDatabase.php");
include("optionDatabase.php");
if(isset($_GET["profile"])){
    header("Location: profile.php");
}
if(isset($_GET["bubble-button"])){
    header("Location: ". $_GET["bubble-button"]);
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
                max-width: 2100px; /* Optional: limit the maximum width */
                background-color: #fff;
                align-items: center;
                align-content: center;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }

            .container .bar {
                background-color: #FFC580;
                height: 40px;
                display: flex;
                align-items: center;
                padding: 10px;
            }

            .container .bar h3 {
                margin: 0;
                padding-left: 10px;
            }

            .dashboard {
                padding: 20px;
                display: flex;
                flex-direction: column; /* Align children vertically */
                align-items: center; /* Center children horizontally */
            }

            .dashboard div span {
                font-size: 1.2em;
            }

            .toggle-buttons {
                display: flex;
                justify-content: center; /* Center buttons horizontally within their container */
                margin-top: 20px;
            }

            .toggle-button {
                background-color: #f0f0f0;
                border: 2px solid #007BFF;
                height: 50px;
                width: 100px;
                border-radius: 10px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                font-size: 14px;
                cursor: pointer;
                transition: all 0.3s ease;
                text-align: center;
                line-height: 50px; /* Vertically center text */
                margin: 0 10px; /* Add space between buttons */
            }

            .toggle-button:hover {
                background-color: #007BFF;
                color: white;
            }

            .toggle-button:active {
                background-color: #0056b3;
                color: white;
            }

            canvas {
                width: 100%;
                height: auto; /* Allow the canvas to adjust its height automatically */
                max-height: 400px; /* Set a maximum height if necessary */
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                margin-top: 20px; /* Adjust margin top for spacing */
            }

            .bubble-button {
                background-color: #f0f0f0;
                border: 2px solid #136163;
                height: 100px;
                width: 150px;
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
                background-color: #00FFFF;
                box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
            }

            .bubble-button:active {
                background-color: #1a98a6;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            }

            .notbubble-button {
                background-color: #f0f0f0;
                border: 2px solid #136163;
                height: 100px;
                width: 150px;
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

            .notbubble-button:hover {
                background-color: #00FFFF;
                box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
            }


    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                    
                    <form class="box" action="home.php" method="get">
                        <input type="hidden" name="profile" value="1">
                        <input type="image" src="Images/logo4.png" width="25" height="25">
                    </form>

            </div>
        </div>
    <div class="wrapper">
        <div class="container">
            <div class="bar">
                <h3>Dashboard</h3>
            </div>
            <div class="dashboard">
                <!-- Toggle buttons for different charts -->
                
                <!-- Box for the chart canvas -->
                    <!-- Chart area -->
                <canvas id="chartCanvas"></canvas>
                <div class="toggle-buttons">
                <button class="toggle-button" onclick="showLineChartl()">Last Year</button>
                <button class="toggle-button" onclick="showLineChart()">Sales</button>
                <button class="toggle-button" onclick="showPieChart()">Items</button>
                </div>
                <!-- Existing buttons -->
                <form action="home.php" method="get">
                    <?php 
                        $countItem = "SELECT * FROM food";
                        $resultCountItem = mysqli_query($connn,$countItem);
                        $itemCount = 0;
                        if(mysqli_num_rows($resultCountItem)>0){
                            while($countItemrow = mysqli_fetch_array($resultCountItem)){
                                $itemCount = $itemCount + 1;
                            }
                            echo"<button class=\"bubble-button\" name=\"bubble-button\" value=\"item.php\">Items<br>(".$itemCount.")</button>";
                        }
                        else{
                            echo"<button class=\"bubble-button\" name=\"bubble-button\" value=\"item.php\">Items<br>(0)</button>";
                        }

                        $countTotalOrder = "SELECT * FROM orderTable";
                        $resultCountOrder = mysqli_query($ordersconn,$countTotalOrder);
                        $totalOrderCount = 0;
                        if(mysqli_num_rows($resultCountOrder)> 0){
                            while($countOrderrow = mysqli_fetch_array($resultCountOrder)){
                                $totalOrderCount = $totalOrderCount + 1;
                            }
                            echo"<button class=\"bubble-button\" name=\"bubble-button\" value=\"order.php#total\">Total Order<br>(".$totalOrderCount.")</button>";
                        }
                        else{
                            echo"<button class=\"bubble-button\" name=\"bubble-button\" value=\"order.php#total\">Total Order<br>(0)</button>";
                        }

                        $countPending = "SELECT * FROM orderTable WHERE statuss = 'Pending'";
                        $resultCountPending = mysqli_query($ordersconn,$countPending);
                        $totalPendingCount = 0;
                        if(mysqli_num_rows($resultCountPending)> 0){
                            while($countPendingrow = mysqli_fetch_array($resultCountPending)){
                                $totalPendingCount = $totalPendingCount + 1;
                            }
                            echo"<button class=\"bubble-button\" name=\"bubble-button\" value=\"order.php#pending\">Pending<br>(".$totalPendingCount.")</button>";
                        }
                        else{
                            echo"<button class=\"bubble-button\" name=\"bubble-button\" value=\"order.php#pending\">Pending<br>(0)</button>";
                        }

                        $countProcessing = "SELECT * FROM orderTable WHERE statuss = 'Processing'";
                        $resultCountProcessing = mysqli_query($ordersconn,$countProcessing);
                        $totalProcessingCount = 0;
                        if(mysqli_num_rows($resultCountProcessing)> 0){
                            while($countProcessingrow = mysqli_fetch_array($resultCountProcessing)){
                                $totalProcessingCount = $totalProcessingCount + 1;
                            }
                            echo"<button class=\"bubble-button\" name=\"bubble-button\" value=\"order.php#processing\">Processing<br>(".$totalProcessingCount.")</button>";
                        }
                        else{
                            echo"<button class=\"bubble-button\" name=\"bubble-button\" value=\"order.php#processing\">Processing<br>(0)</button>";
                        }
                        $countComplete = "SELECT * FROM orderTable WHERE statuss = 'Completed'";
                        $resultCountComplete = mysqli_query($ordersconn,$countComplete);
                        $totalCompleteCount = 0;
                        if(mysqli_num_rows($resultCountComplete)> 0){
                            while($countCompleterow = mysqli_fetch_array($resultCountComplete)){
                                $totalCompleteCount = $totalCompleteCount + 1;
                            }
                            echo"<button class=\"bubble-button\" name=\"bubble-button\" value=\"order.php#complete\">Completed<br>(".$totalCompleteCount.")</button>";
                        }
                        else{
                            echo"<button class=\"bubble-button\" name=\"bubble-button\" value=\"order.php#complete\">Completed<br>(0)</button>";
                        }
                        $countCancel = "SELECT * FROM orderTable WHERE statuss = 'Cancelled'";
                        $resultCountCancel = mysqli_query($ordersconn,$countCancel);
                        $totalCancelCount = 0;
                        if(mysqli_num_rows($resultCountCancel)> 0){
                            while($countCancelrow = mysqli_fetch_array($resultCountCancel)){
                                $totalCancelCount = $totalCancelCount + 1;
                            }
                            echo"<button class=\"bubble-button\" name=\"bubble-button\" value=\"order.php#cancelled\">Cancelled<br>(".$totalCancelCount.")</button>";
                        }
                        else{
                            echo"<button class=\"bubble-button\" name=\"bubble-button\" value=\"order.php#cancelled\">Cancelled<br>(0)</button>";
                        }
                        $countProfit = "SELECT * FROM orderTable WHERE statuss = 'Completed'";
                        $resultCountProfit = mysqli_query($ordersconn,$countProfit);
                        $totalProfitCount = 0;
                        if(mysqli_num_rows($resultCountProfit)> 0){
                            while($countProfitrow = mysqli_fetch_array($resultCountProfit)){
                                $totalProfitCount = $totalProfitCount + $countProfitrow["price"];
                            }
                            echo"<button class=\"notbubble-button\" name=\"not-bubble-button\">Total Profits<br>(RM ".$totalProfitCount.")</button>";
                        }
                        else{
                            echo"<button class=\"notbubble-button\" name=\"not-bubble-button\">Total Profits<br>(RM 0)</button>";
                        }
                    ?>
                </form>
                <script>
                    // PHP Data
                    <?php
                    $findSalesSql="SELECT * FROM month WHERE years=(SELECT MAX(years) FROM month)";
                    $resultFindSalesSql = mysqli_query($ordersconn, $findSalesSql);
                    if(mysqli_num_rows($resultFindSalesSql)> 0){
                        $row = mysqli_fetch_array($resultFindSalesSql);
                        $values = array($row["january"], $row["february"], $row["march"], $row["april"], $row["may"], $row["june"], $row["july"], $row["august"], $row["september"], $row["october"], $row["november"],$row["december"],);
                    }
                    else{
                        $addYear = "INSERT INTO month (years) VALUES (YEAR(CURDATE()))";
                        $resultaddYear = mysqli_query($ordersconn, $addYear);
                        if($resultaddYear){
                            $values = array(NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,);
                        }
                    }
                    
                    $data = [
                        'labels' => ['January', 'February', 'March', 'April', 'May', 'June', 'July','August','September','October','November','December'],
                        'values' => [$values[0], $values[1], $values[2], $values[3], $values[4], $values[5], $values[6], $values[7], $values[8], $values[9], $values[10], $values[11]]

                    ];
                    $findSalesSqll="SELECT * FROM month WHERE years=(SELECT MAX(years)-1 FROM month)";
                    $resultFindSalesSqll = mysqli_query($ordersconn, $findSalesSqll);
                    if(mysqli_num_rows($resultFindSalesSqll)> 0){
                        $rowl = mysqli_fetch_array($resultFindSalesSqll);
                        $valuesl = array($rowl["january"], $rowl["february"], $rowl["march"], $rowl["april"], $rowl["may"], $rowl["june"], $rowl["july"], $rowl["august"], $rowl["september"], $rowl["october"], $rowl["november"],$rowl["december"],);
                    }
                    else{
                        $valuesl = array(NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,);
                    }

                    $datal = [
                        'labels' => ['January', 'February', 'March', 'April', 'May', 'June', 'July','August','September','October','November','December'],
                        'values' => [$valuesl[0], $valuesl[1], $valuesl[2], $valuesl[3], $valuesl[4], $valuesl[5], $valuesl[6], $valuesl[7], $valuesl[8], $valuesl[9], $valuesl[10], $valuesl[11]]
                    ];

                    $category= array();
                    $item=array();
                    $findCategorySql="SELECT * FROM category";
                    $resultFindCategorySql = mysqli_query($optionsconn,$findCategorySql);
                    if(mysqli_num_rows($resultFindCategorySql)> 0){
                        while($categoryrow = mysqli_fetch_array($resultFindCategorySql)){
                            $category[] = $categoryrow["categorys"];
                            $item[] = 0;
                        }
                    }
                    $findItem = "SELECT foodcategory FROM food";
                    $resultFindItemSql = mysqli_query($connn,$findItem);
                    if(mysqli_num_rows($resultFindItemSql)> 0){
                        while($itemrow = mysqli_fetch_array($resultFindItemSql)){
                            for($i= 0;$i<count($category);$i++){
                                if($itemrow["foodcategory"] == $category[$i]){  
                                    $item[$i] = $item[$i] + 1;
                                }
                            }
                        }
                    }
                    ?>

                    // Convert PHP arrays to JavaScript arrays
                    const labels = <?php echo json_encode($data['labels']); ?>;
                    const salesData = <?php echo json_encode($data['values']); ?>;
                    const labelsl = <?php echo json_encode($datal['labels']); ?>;
                    const salesDatal = <?php echo json_encode($datal['values']); ?>;
                    const itemsData = <?php echo json_encode($item); ?>;
                    const itemsLabel = <?php echo json_encode($category);?>;

                    let currentChart;

                    function createChart(type, data) {
                        if (currentChart) {
                            currentChart.destroy();
                        }

                        const ctx = document.getElementById('chartCanvas').getContext('2d');
                        currentChart = new Chart(ctx, {
                            type: type,
                            data: data,
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                            }
                        });
                    }

                    function showLineChart() {
                        const data = {
                            labels: labels,
                            datasets: [{
                                label: 'Monthly Sales',
                                data: salesData,
                                borderColor: 'rgba(75, 192, 192, 1)',
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                fill: true,
                            }]
                        };
                        createChart('line', data);
                    }
                    function showLineChartl() {
                        const data = {
                            labels: labelsl,
                            datasets: [{
                                label: 'Monthly Sales',
                                data: salesDatal,
                                borderColor: 'rgba(75, 192, 192, 1)',
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                fill: true,
                            }]
                        };
                        createChart('line', data);
                    }

                    function showPieChart() {
                        const data = {
                            labels: itemsLabel,
                            datasets: [{
                                label: 'Item Distribution',
                                data: itemsData,
                                backgroundColor: [
                                    'rgba(255, 99, 132, 0.2)',
                                    'rgba(54, 162, 235, 0.2)',
                                    'rgba(75, 192, 192, 0.2)',
                                ],
                                borderColor: [
                                    'rgba(255, 99, 132, 1)',
                                    'rgba(54, 162, 235, 1)',
                                    'rgba(75, 192, 192, 1)',
                                ],
                                borderWidth: 1,
                            }]
                        };
                        createChart('pie', data);
                    }

                    // Show default chart (Line Chart)
                    showLineChart();
                </script>
            </div>
        </div>
    </div>
</body>
</html>
