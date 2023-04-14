<?php

session_start();
require('connect.php');
    

     // SQL is written as a String.
    $query = "SELECT * FROM item ORDER BY last_update DESC";
    $queryCat = "SELECT * FROM category";
    $queryCon = "SELECT * FROM console";

    $statement = $db->prepare($query);
    $statementCat = $db->prepare($queryCat);
    $statementCon = $db->prepare($queryCon);
    
    //  Bind values to the parameters
    
    //  Execute the INSERT.
    //  execute() will check for possible SQL injection and remove if necessary
    $statement->execute(); 
    $statementCat->execute(); 
    $statementCon->execute();

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
                <h3><a href="login.php">login</a>/<a href="register.php">register</a></h3>
            <?php else: ?>
                <h3><a href="profile.php">profile</a>/<a href="logout.php">logout</a></h3>
            <?php endif ?>
        </div>

        <ul id="menu">
            <li><a href="index.php" class='active'>Home</a></li>
            <?php if(isset($_SESSION['userrole'])): ?>
                <li><a href="post.php">Post Item</a></li>
            <?php endif ?>
        </ul>

        <ul id="menu">
            <li>
                <form method="post" action="showConsole.php">
                        <select id="console" name="console">
                            <?php while($rowCon = $statementCon->fetch()): ?>
							<option value="<?= $rowCon['console_title']?>"><?= $rowCon['console_title']?></option>
                            <?php endwhile ?>
						</select>
                    <input type="submit">
                </form >
            </li>
            <li>
                <form method="post" action="showCategories.php">
                    <select id="Categories" name="Categories">
                        <?php while($rowCat = $statementCat->fetch()): ?>
							<option value="<?= $rowCat['categories']?>"><?= $rowCon['info']?></option>
                        <?php endwhile ?>
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
                    <p><small><?= date("F j, Y, g:i a", $timestamp) ?> -<a href="show.php?item_id=<?= $rows['item_id']?>">see full post</a></small>
                    </p>
                    <p><?= $rows['console'] ?></p>
                    <p><?= $rows['categories'] ?></p>
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