<?php

session_start();
require('connect.php');
    
$queryConS = "SELECT * FROM console";
$statementConS = $db->prepare($queryConS);
$statementConS->execute();

     // SQL is written as a String.
    $query = false;
    if($_GET && isset($_GET['name'])){
        $query = "SELECT * FROM item ORDER BY game ASC";
    }elseif($_GET && isset($_GET['console'])){
        $query = "SELECT * FROM item ORDER BY console ASC";
    }elseif($_GET && isset($_GET['categories'])){
        $query = "SELECT * FROM item ORDER BY categories ASC";
    }elseif($_GET && isset($_GET['time'])){
        $query = "SELECT * FROM item ORDER BY last_update DESC";
    }elseif($_GET && isset($_GET['price'])){
        $query = "SELECT * FROM item ORDER BY price ASC";
    }else{
        $query = "SELECT * FROM item ORDER BY item_id ASC";
    }
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

    <div id="container">
        <div id="header">
            <h1><a href="index.php">Graphic Card Haters</a></h1>

            <div id="searching">
                <form method="post" action="search.php">
                    <input type="hidden" name="formStatus" value="search">
                    <label for="search">Search:</label><br>
                    <input id="search" name="search"><br>
                    <label for="base">Search From</label><br>
                    <select id="base" name="base">
                        <option value="All" selected>All console</option>
                        <?php while($rowConS = $statementConS->fetch()): ?>
                            <option value="<?= $rowConS['console_title']?>"><?= $rowConS['console_title']?></option>
                        <?php endwhile ?>
					</select><br>
                    <input type="submit" value="search">
                </form>
            </div>

            <?php if(!isset($_SESSION['userrole'])): ?>
                <h3><a href="login.php">login</a>/<a href="register.php">register</a></h3>
            <?php else: ?>
                <h3><a href="profile.php">profile</a>/<a href="logout.php">logout</a></h3>
            <?php endif ?>
        </div>

        <ul id="menu">
            <li><a href="index.php" class='active'>Home</a></li>
            <?php if(isset($_SESSION['userrole'])): ?>
                <li><a href="postPre.php">Post Item</a></li>
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
                    <select id="categories" name="categories">
                        <?php while($rowCat = $statementCat->fetch()): ?>
							<option value="<?= $rowCat['categories']?>"><?= $rowCat['info']?></option>
                        <?php endwhile ?>
					</select>
                    <input type="submit">
                </form >
            </li>
        </ul>

        <div id="showcard">
                    <table class="item_post">
                        <caption>Recent Post</caption>
                        <tr>
                            <th onclick="window.location='index.php?name=true';">Game Name</th>
                            <th onclick="window.location='index.php?console=true';">Console</th>
                            <th onclick="window.location='index.php?categories=true';">Categories</th>
                            <th onclick="window.location='index.php?time=true';">Update</th>
                            <th onclick="window.location='index.php?price=true';">price</th>
                        </tr>
                    <?php while($rows = $statement->fetch()): ?>
                            <tr onclick="window.location='show.php?item_id=<?= $rows['item_id']?>';">
                                <td><?= $rows['game'] ?></td>
                                <td><?= $rows['console'] ?></td>
                                <td><?= $rows['categories'] ?></td>
                                <?php $timestamp = strtotime($rows['last_update']);?>
                                <td><?= date("F j, Y, g:i a", $timestamp) ?></td>
                                <td><?= $rows['price'] ?></td>
                            </tr>
                    <?php endwhile ?>
                    </table>
        </div>

        <div id="footer">
            Copywrong 2023 - No Rights Reserved Yet
        </div>
    </div>
    </div>
</body>
</html>