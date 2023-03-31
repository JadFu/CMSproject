<?php

ini_set('session.gc_maxlifetime', 18000);
session_start();
require('connect.php');
    
if ($_POST && !empty($_POST['main_catalog']) ){

    $main_catalog = filter_input(INPUT_POST, 'main_catalog', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

     // SQL is written as a String.
     $query = "SELECT * FROM item WHERE main_catalog = :main_catalog";

     // A PDO::Statement is prepared from the query.
     $statement = $db->prepare($query);
     $statement->bindValue(':main_catalog', $main_catalog);
     // Execution on the DB server is delayed until we execute().
     $statement->execute(); 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>Graphic Card Haters: Catalog: <?= $main_catalog ?></title>
</head>
<body>
    <!-- Remember that alternative syntax is good and html inside php is bad -->

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