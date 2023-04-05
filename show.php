<?php

session_start();
require('connect.php');
    
    $item_id = filter_input(INPUT_GET, 'item_id', FILTER_SANITIZE_NUMBER_INT);
     // SQL is written as a String.
     $query = "SELECT * FROM item WHERE item_id = $item_id";
     $comQuery = "SELECT comment.comment_id, comment.item_id, comment.user_id, comment.post_time, comment.comments, user.name
                    FROM comment JOIN user ON comment.user_id = user.user_id
                    WHERE comment.item_id = $item_id
                    ORDER BY comment.post_time DESC";

     // A PDO::Statement is prepared from the query.
     $statement = $db->prepare($query);
     $comStatement = $db->prepare($comQuery);

     // Execution on the DB server is delayed until we execute().
     $statement->execute(); 
     $comStatement->execute();

     $rows = $statement->fetch();


if ($_POST
        && !empty($_POST['item_id']) 
        && !empty($_POST['user_id'])
        && isset($_POST['comments'])) {
    //  Sanitize user input to escape HTML entities and filter out dangerous characters.
    $comItem_id = filter_input(INPUT_POST, 'item_id', FILTER_VALIDATE_INT);
    $user_id = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT);
    $comments = filter_input(INPUT_POST, 'comments', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    
    //  Build the parameterized SQL query and bind to the above sanitized values.
    $comPostQuery = "INSERT INTO comment(item_id, user_id, comments) VALUES (:comItem_id, :user_id, :comments)";
    $comPostStatement = $db->prepare($comPostQuery);
    
    //  Bind values to the parameters
    $comPostStatement->bindValue(':comItem_id', $comItem_id);
    $comPostStatement->bindValue(':user_id', $user_id);
    $comPostStatement->bindValue(':comments', $comments);
    
    //  Execute the INSERT.
    //  execute() will check for possible SQL injection and remove if necessary
    $comPostStatement->execute(); 

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>POST: <?= ":item_id" ?></title>
</head>
<body>
    <!-- Remember that alternative syntax is good and html inside php is bad -->
    <div id="wrapper">
        <?php if(filter_input(INPUT_GET, 'item_id', FILTER_VALIDATE_INT)):?>

            <div id="all_blogs">

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

            <div id="comment">
                <?php while($comRows = $comStatement->fetch()): ?>
                    <h3><?= $comRows['name'] ?></h3>
                    <p><small><?= date("F j, Y, g:i a", $timestamp) ?>
                        <!--<?php if(isset($_SESSION['user_id'])): ?>
                        -<a href="editCom.php?comment_id=<?= $rows['comment_id']?>">edit</a></small>
                        <?php endif ?>-->
                    </p>
                    <p><?= $comRows['comments'] ?></p>
                <?php endwhile ?>  
            </div>

            <?php if(isset($_SESSION['user_id'])):?>
                <div id="commentPost">
                    <form method="post" action="show.php?item_id=<?= $item_id?>">

                    <input type="hidden" name="item_id" value="<?= $item_id ?>">
                    <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>">

                        <label for="comments">post comments</label><br>
                        <textarea id="comments" name="comments" rows="10" cols="100"></textarea>

                        <input type="submit">
                    </form>
                </div>
            <?php endif ?>


        <?php else: ?>
            <h3>Invalid Post ID: Cannot find post information</h3>
            <h2><a href="index.php">Go Back To Home page</a></h2>

        <?php endif ?>

        <h2><a href="index.php">Go Back To GCH Home page</a></h2>
    </div>

</body>
</html>