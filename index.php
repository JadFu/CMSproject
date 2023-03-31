<?php

session_start();
ini_set('session.gc_maxlifetime', 18000);
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
            <?php if(!isset($_SESSION['userrole'])): ?>
                <h3><a href="login.php">login</a>/<a href="register.php" onclick="<?php session_destroy(); ?>">register</a></h3>
            <?php else: ?>
                <h3><a href="index.php" onclick="<?php session_destroy(); ?>">logout</a></h3>
            <?php endif ?>
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
                    <p><?= $rows['game'] ?></p>
                    <?php $timestamp = strtotime($rows['last_update']);?>
                    <p><small><?= date("F j, Y, g:i a", $timestamp) ?>
                        <?php if(isset($_SESSION['userrole']) && ($_SESSION['user_id'] === $rows['user_id'] || $_SESSION['userrole'] === 'admin')): ?>
                        -<a href="edit.php?item_id=<?= $rows['item_id']?>">edit</a></small>
                        <?php endif ?>
                    </p>
                    <p><?= $rows['console'] ?></p>
                    <p><?= $rows['main_catalog'] ?></p>
                    <p><?= $rows['area'] ?></p>
                    <p><?= $rows['current_condition'] ?></p>
                    <p><?= $rows['info'] ?></p>
                    <p><?= $rows['price'] ?></p>
                </div>
            <?php endwhile ?>
        </div>
    </div>

    <div id="footer">
        Copywrong 2023 - No Rights Reserved Yet
    </div>

</body>
</html>