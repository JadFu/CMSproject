<?php

session_start();
require('connect.php');


if ($_POST && $_POST['formStatus'] == 'deleteComment') {
        // Sanitize user input to escape HTML entities and filter out dangerous characters.
        $item_id = filter_input(INPUT_POST, 'item_id', FILTER_SANITIZE_NUMBER_INT);
        $comment_id = filter_input(INPUT_POST, 'comment_id', FILTER_SANITIZE_NUMBER_INT);

        // Build the parameterized SQL query and bind to the above sanitized values.
        $query = "DELETE FROM comment WHERE comment_id = :comment_id";
        $statement = $db->prepare($query);

        $statement->bindValue(':comment_id', $comment_id, PDO::PARAM_INT);
        
        // Execute the INSERT.
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
    <title>Delete Comment</title>
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
                    <input type="submit" value="search">
                </form>
            </div>

            <?php if(!isset($_SESSION['userrole'])): ?>
                <h3><a href="login.php">login</a>/<a href="register.php">register</a></h3>
            <?php else: ?>
                <h3><a href="profile.php">profile</a>/<a href="logout.php">logout</a></h3>
            <?php endif ?>
        </div>
<div id='reportcard'>
    <!-- Remember that alternative syntax is good and html inside php is bad -->
    <?php if(!filter_input(INPUT_POST, 'comment_id', FILTER_VALIDATE_INT) || $_POST['formStatus'] != 'deleteComment'):?>

        <h3>Failed to delete Comment: Cannot find Comment information</h3>
        <h2><a href="index.php">Go Back To Home Page</a></h2>

    <?php else: ?>
        <h2>Success</h2>
        <h2><a href="show.php?item_id=<?= $item_id?>">Go Back To Post</a></h2>
        <h2><a href="index.php">Go Back To Home Page</a></h2>

    <?php endif ?>
    </div>
    </div>
</body>
</html>