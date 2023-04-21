<?php

session_start();
require('connect.php');


$commentStatus = false;
if ($_POST && $_POST['formStatus'] == 'comment')  {
    //  Sanitize user input to escape HTML entities and filter out dangerous characters.
    $item_id = filter_input(INPUT_POST, 'item_id', FILTER_VALIDATE_INT);
    $user_id = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT);
    $comments = filter_input(INPUT_POST, 'comments', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    
    //  Build the parameterized SQL query and bind to the above sanitized values.
    $query = "INSERT INTO comment(item_id, user_id, comments) VALUES (:item_id, :user_id, :comments)";
    $statement = $db->prepare($query);
    
    //  Bind values to the parameters
    $statement->bindValue(':item_id', $item_id);
    $statement->bindValue(':user_id', $user_id);
    $statement->bindValue(':comments', $comments);
    
    //  Execute the INSERT.
    //  execute() will check for possible SQL injection and remove if necessary
    if($statement->execute()){
        $commentStatus = true;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
    <?php if($commentStatus): ?>
        <script type='text/javascript'>alert('Comment Success: heading back to game post');</script>
        <?php header("Location: show.php?item_id=$item_id"); ?>
    <?php else: ?>
        <script type='text/javascript'>alert('Comment Failed: heading back to game post');</script>
        <?php header("Location: show.php?item_id=$item_id"); ?>
    <?php endif ?>
    </div>
</body>
</html>
