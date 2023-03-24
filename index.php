<?php


require('connect.php');
    
     // SQL is written as a String.
     $query = "SELECT * FROM item ";

     // A PDO::Statement is prepared from the query.
     $statement = $db->prepare($query);

     // Execution on the DB server is delayed until we execute().
     $statement->execute(); 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>Welcome to Graphic Card Haters</title>
</head>
<body>
    <!-- Remember that alternative syntax is good and html inside php is bad -->

    <div id="wrapper">
        <div id="header">
            <h1><a href="index.php">Graphic Card Haters</a></h1>
        </div>

        <ul id="menu">
            <li><a href="index.php" class='active'>Home</a></li>
            <li><a href="post.php">Post Item</a></li>
        </ul>

        <ul id="menu">
            <li>
                <form method="post" action="showConsole.php">
                        <select id="console" name="console">
								<option value="Nintendo Switch">Nintendo Switch</option>
								<option value="PlayStation 4">PlayStation 4</option>
								<option value="PlayStation 5">PlayStation 5</option>
								<option value="Steam Deck">Steam Deck</option>
								<option value="Xbox One">Xbox One</option>
								<option value="Xbox Series X/S">Xbox Series X/S</option>
                                <option value="others">others</option>
						</select>
                    <input type="submit">
                </form >
            </li>
            <li>
                <form method="post" action="showCatalog.php">
                    <select id="main_catalog" name="main_catalog">
								<option value="BSG">Business simulation game</option>
								<option value="FPS">First-person Shooter</option>
								<option value="Horror">Horror game</option>
								<option value="Music">Music game</option>
								<option value="Rougelike">plural rougelikes</option>
								<option value="RPG">Role-play game</option>
                                <option value="RTS">Real-time Strategy</option>
                                <option value="TBS">Turn-based Strategy</option>
                                <option value="Others">others</option>
						</select>
                    <input type="submit">
                </form >
            </li>
        </ul>

        <div id="all_item">
            <?php while($rows = $statement->fetch()): ?> 
                <div class="item_post">
                    <h5><?= $rows['user_id'] ?></h5>
                    <h5><?= $rows['game'] ?></h5>
                    <h5><?= $rows['last_update'] ?></h5>
                    <h5><?= $rows['console'] ?></h5>
                    <h5><?= $rows['main_catalog'] ?></h5>
                    <h5><?= $rows['area'] ?></h5>
                    <h5><?= $rows['current_condition'] ?></h5>
                    <h5><?= $rows['info'] ?></h5>
                    <h5><?= $rows['price'] ?></h5>
                </div>
            <?php endwhile ?>
        </div>
    </div>

    <div id="footer">
        Copywrong 2023 - No Rights Reserved Yet
    </div>

</body>
</html>