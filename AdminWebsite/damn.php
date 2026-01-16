<!DOCTYPE html>
<html lang="en">
    <head>
        <style>
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
            cursor: pointer; /* Make it look like a clickable link */
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
        </style>
    </head>
    <body>
        <?php
        echo"
        <div class=\"food-item\">
        <img src=\"path_to_your_images_directory/placeholder.png\" alt=\"Drink 1\">
        <h4>DRINK 1</h4>
        <p>Description for Drink 1</p>
        <p class=\"price\">RM X</p>

        </div>
        <div class=\"food-item\">
            <img src=\"path_to_your_images_directory/placeholder.png\" alt=\"Drink 2\">
            <h4>DRINK 2</h4>
            <p>Description for Drink 2</p>
            <p class=\"price\">RM X</p>

        </div>
        <div class=\"food-item\">
            <img src=\"path_to_your_images_directory/placeholder.png\" alt=\"Drink 3\">
            <h4>DRINK 3</h4>
            <p>Description for Drink 3</p>
            <p class=\"price\">RM X</p>

        </div>
        <div class=\"food-item\">
            <img src=\"path_to_your_images_directory/placeholder.png\" alt=\"Drink 4\">
            <h4>DRINK 4</h4>
            <p>Description for Drink 4</p>
            <p class=\"price\">RM X</p>

        </div>
        <div class=\"food-item\">
            <img src=\"path_to_your_images_directory/placeholder.png\" alt=\"Drink 5\">
            <h4>DRINK 5</h4>
            <p>Description for Drink 5</p>
            <p class=\"price\">RM X</p>

        </div>
        <div class=\"food-item\">
            <img src=\"path_to_your_images_directory/placeholder.png\" alt=\"Drink 6\">
            <h4>DRINK 6</h4>
            <p>Description for Drink 6</p>
            <p class=\"price\">RM X</p>

        </div>
        ";
        ?>
    </body>
</html> 