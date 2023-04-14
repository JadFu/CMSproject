<?php

session_start();
require('connect.php');


if ($_POST && !empty($_POST['categories']) ){

    $categories = filter_input(INPUT_POST, 'categories', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

     // SQL is written as a String.
     $query = "SELECT * FROM item WHERE categories = :categories";

     // A PDO::Statement is prepared from the query.
     $statement = $db->prepare($query);

     $statement->bindValue(':categories', $categories);
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
    <title>Graphic Card Haters: Categories: <?= $categories ?></title>
</head>
<body>
    <!-- Remember that alternative syntax is good and html inside php is bad -->

        <div id="all_item">
            <?php while($rows = $statement->fetch()): ?>
                <div class="item_post">
                    <p><?= $rows['game'] ?></p>
                    <?php $timestamp = strtotime($rows['last_update']);?>
                    <p><small><?= date("F j, Y, g:i a", $timestamp) ?> -<a href="show.php?item_id=<?= $rows['item_id']?>">see full post</a></small>
                    </p>
                    <p><?= $rows['console'] ?></p>
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