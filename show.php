<?php

session_start();
require('connect.php');
$queryConS = "SELECT * FROM console";
$statementConS = $db->prepare($queryConS);
$statementConS->execute(); 
    $item_id = filter_input(INPUT_GET, 'item_id', FILTER_SANITIZE_NUMBER_INT);

     // SQL is written as a String.
     $query = "SELECT * FROM item WHERE item_id = :item_id";
     $queryCom = "SELECT comment.comment_id, comment.item_id, comment.user_id, comment.post_time, comment.comments, user.name
                    FROM comment JOIN user ON comment.user_id = user.user_id
                    WHERE comment.item_id = :item_id
                    ORDER BY comment.post_time DESC";

     // A PDO::Statement is prepared from the query.
     $statement = $db->prepare($query);
     $statementCom = $db->prepare($queryCom);

     $statement->bindValue(':item_id', $item_id, PDO::PARAM_INT);
     $statementCom->bindValue(':item_id', $item_id, PDO::PARAM_INT);

     // Execution on the DB server is delayed until we execute().
     $statement->execute();
     $statementCom->execute(); 

     $rows = $statement->fetch();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>POST: <?=  $rows['game'] ?></title>
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
        <?php if(filter_input(INPUT_GET, 'item_id', FILTER_VALIDATE_INT)):?>

            <div id="post_detail">

                    <p><?= $rows['game'] ?></p>
                    <?php $timestamp = strtotime($rows['last_update']);?>
                            <p>
							<img src="uploads/<?= $rows['img'] ?>" alt="picture" width="600" height="400">
                            </p>
                    <p><small><?= date("F j, Y, g:i a", $timestamp) ?>
                        <?php if(isset($_SESSION['user_id']) && ($rows['user_id'] === $_SESSION['user_id'] || $_SESSION['userrole'] === 'admin')): ?>
                        -<a href="edit.php?item_id=<?= $rows['item_id']?>">edit</a></small>
                        <?php endif ?>
                    </p>
                    <p><?= $rows['console'] ?></p>
                    <p><?= $rows['categories'] ?></p>
                    <p><?= $rows['area'] ?></p>
                    <p><?= $rows['current_condition'] ?></p>
                    <p><?= $rows['info'] ?></p>
                    <p><?= $rows['price'] ?></p>
                
            </div>

            <div id="comments">
                <br><h2>Comments: </h2>
                <?php while($rowCom = $statementCom->fetch()): ?>
                    <div id="showcard">
                    <h3><?= $rowCom['name'] ?></h3>
                    <p><small><?= date("F j, Y, g:i a", $timestamp) ?>
                        <?php if(isset($_SESSION['user_id']) && ($rows['user_id'] == $_SESSION['user_id'] || $_SESSION['userrole'] === 'admin')): ?>
                        -<a href="editCom.php?comment_id=<?= $rowCom['comment_id']?>">edit comments</a></small>
                        <?php endif ?>
                    </p>
                    <p><?= $rowCom['comments'] ?></p>
                    </div>
                <?php endwhile ?>  
            </div>

            <?php if(isset($_SESSION['user_id'])):?>
                <div id="commentPost">
                    <form method="post" action="comment.php?item_id=<?= $item_id?>">

                    <input type="hidden" name="formStatus" value="comment">
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