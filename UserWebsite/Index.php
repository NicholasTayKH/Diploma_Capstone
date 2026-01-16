
<?php
         if (isset($_POST["submit"])){
         header("Location: Login.php");
}
?> 



<!DOCTYPE html>
<html lang="en">
    <head>     
    
    <meta charset="utf-8">
    <title></title>
        
    <meta name="viewport" contents="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">

    </head>
     
        <header>
            <div class="header-logo">
                <marque>
                <img  src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS8Aa4QEjqnv4nqpUQY_kQzeHuo1C609_FT4w&s" alt="INTI International College Penang Logo">
                </marque>
            </div>
        </header>
        <style>body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    min-height: 100vh;
    background-color: #f8f8f8;
}

header {
    background-color: #000;
    width: 100%;
    padding: 20px 20px;
    display: flex;
    justify-content: left;
    position: fixed;
    top: 0;
    left: 0;
    z-index: 1000;
}

.header-logo img {
    height: 40px;
}

main {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    padding: 80px 20px 20px; 
}

.intro {
    max-width: auto;
    margin-bottom: 20px;
}

h1 {
    
    font-size: 50px;
    max-height: auto;
    color: black;
    
    
}
.image img {
    background-position:center;
    align-items:center;
    width: auto;
    max-width: auto;
    height: auto;
    
}

h2 {
    font-size: 30px;
    margin: 0px 0px;
    height:auto;
    color: black;
}

p {
    font-size: 16px;
    color: black;
    align-self:auto;
}

.order-button {
    padding: 10px 20px;
    font-size: 16px;
    color: #fff;
    background-color: #000;
    border: none;
    cursor: pointer;
    margin-top: 20px;
    text-decoration: none;
    display: inline-block;
   
}

.order-button:hover {
    background-color: #333;
    
}



</style>
        <main>
            <section class="intro">
                <h1>INTI INTERNATIONAL N
                    <br>COLLEGE PENANG</h1>
                <h2>Online Canteen Web</h2>
                <p>Welcome to our college canteen,where delicious<br>meals and a vibrant atmosphere create the<br>perfect spot to relax, recharge, and connect with<br>friends.</p>
                <form action="Index.php" method="post">
                    <button type="submit" name="submit" class="order-button"> Order now</button>
                </form>

            </section>
            

        </main>
        
        <style> 
        body{
            background-image:url('https://images.pexels.com/photos/1640773/pexels-photo-1640773.jpeg');
            background-repeat:no-repeat;
            background-size:cover;
            max-width: 100%;
            height:auto;
        }
    
    
        
        </style>


    </body>


</html>

