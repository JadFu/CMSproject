<?php

session_start();
require('connect.php');

if (isset($_GET['comment_id'])) { // Retrieve quote to be edited, if id GET parameter is in URL.
        // Sanitize the id. Like above but this time from INPUT_GET.
        $comment_id = filter_input(INPUT_GET, 'comment_id', FILTER_SANITIZE_NUMBER_INT);
        
        // Build the parametrized SQL query using the filtered id.
        $query = "SELECT * FROM comment WHERE comment_id = :comment_id";
        $statement = $db->prepare($query);
        $statement->bindValue(':comment_id', $comment_id, PDO::PARAM_INT);
        
        // Execute the SELECT and fetch the single row returned.
        $statement->execute();
        $rows = $statement->fetch();

    } else {
        $comment_id = false; // False if we are not UPDATING or SELECTING.
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>Edit this Comment!</title>
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
						<option value="name">Game Name</option>
                        <option value="console">Console</option>
                        <option value="category">Category</option>
					</select><br>
                    <input type="submit">
                </form>
            </div>

            <?php if(!isset($_SESSION['userrole'])): ?>
                <h3><a href="login.php">login</a>/<a href="register.php">register</a></h3>
            <?php else: ?>
                <h3><a href="profile.php">profile</a>/<a href="logout.php">logout</a></h3>
            <?php endif ?>
        </div>
    <!-- Remember that alternative syntax is good and html inside php is bad -->
    <div id="postcard">
        <?php if(isset($_SESSION['user_id'])):?>
            <form method="post" action="updateCom.php">

                <input type="hidden" name="formStatus" value="updateComment">
                <input type="hidden" name="item_id" value="<?= $rows['item_id'] ?>">
                <input type="hidden" name="comment_id" value="<?= $_GET['comment_id'] ?>">

                        <label for="comments">post comments</label><br>
                        <textarea id="comments" name="comments" rows="10" cols="100"><?= $rows['comments'] ?></textarea>
                        <input type="submit">
            </form>

            <fieldset id="delete">
                <legend>Delete:</legend>
                <h2>Caution: Do Not Miss Click!</h2>
                <h3>The following button will delete this comment and information cannot be restored once deleted</h3>
                <form method="post" action="deleteCom.php">
                    <input type="hidden" name="formStatus" value="deleteComment">
                    <input type="hidden" name="item_id" value="<?= $rows['item_id'] ?>">
                    <input type="hidden" name="comment_id" value="<?= $_GET['comment_id'] ?>">
                    <input type="submit" value="delete">
                </form>
            </fieldset>
        <?php else: ?>
            <div id='reportcard'>
            <h2>Seems like You haven't sign in...</h2>
            <h3>Please <a href="login.php">Sign in</a> or <a href="register.php">Register</a>.</h3>
            <h2><a href="index.php">Go Back To GCH Home page</a></h2>
            </div>
        <?php endif ?>
    </div>
    </div>
</body>
</html>