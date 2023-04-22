<?php

session_start();
require('connect.php');

$queryConS = "SELECT * FROM console";
$statementConS = $db->prepare($queryConS);
$statementConS->execute();

    $validSearch = false;
    $query = false;
    $search = filter_input(INPUT_POST, 'search', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $base = filter_input(INPUT_POST, 'base', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    if($_POST && $_POST['formStatus'] == 'search' && $_POST['base'] == "All"){
        $validSearch = true;
        $query = "SELECT * FROM item 
                    WHERE game LIKE '%{$search}%'
                    OR console LIKE '%{$search}%'
                    OR categories LIKE '%{$search}%'
                    OR info LIKE '%{$search}%'
                    ORDER BY last_update DESC";
        $statement = $db->prepare($query);
    }elseif($_POST && $_POST['formStatus'] == 'search'){
        $validSearch = true;
        $baseterm = $_POST['base'];
        $query = "SELECT * FROM item 
                    WHERE (console = :baseterm AND game LIKE '%{$search}%')
                    OR (console = :baseterm AND categories LIKE '%{$search}%')
                    OR (console = :baseterm AND info LIKE '%{$search}%')";
        $statement = $db->prepare($query);
        $statement->bindValue(':baseterm', $baseterm);
    }
     // A PDO::Statement is prepared from the query.
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
    <title>Graphic Card Haters: Categories: <?= $categories ?></title>
</head>
<body>
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
    <!-- Remember that alternative syntax is good and html inside php is bad -->

        <?php if($validSearch): ?>
            <div id="showcard">
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
        <?php else: ?>
            <div id='reportcard'>
                <h3>Search Terms invalid!</h3>
                <h2><a href="index.php">Go Back To Home Page</a></h2>
            </div>
        <?php endif ?>
        </div>

    <div id="footer">
        Copywrong 2023 - No Rights Reserved Yet
    </div>
    </div>
</body>
</html>