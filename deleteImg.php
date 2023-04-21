<?php

session_start();
require('connect.php');


if ($_POST && $_POST['formStatus'] == 'deleteImg') {

    $item_id = filter_input(INPUT_POST, 'item_id', FILTER_SANITIZE_NUMBER_INT);

    $query = "SELECT * FROM ITEM WHERE item_id = :item_id";
    
        $statement = $db->prepare($query);
        $statement->bindValue(':item_id', $item_id, PDO::PARAM_INT);
        // Execute the SELECT and fetch the single row returned.
        $statement->execute(); 
        $rows = $statement->fetch();

    if(!($rows['img'] === 'NullImg.jpg')){
        $destination = $rows['img'];
        array_map('unlink', array_filter(glob("uploads/{$destination}"), 'is_file'));
    }

        $queryImg = "UPDATE item SET img = 'NullImg.jpg' WHERE item_id = :item_id";
    
        $statementImg = $db->prepare($queryImg);
    
        $statementImg->bindValue(':item_id', $item_id);
    
        if($statementImg->execute()){
            echo "image deleted!";
        }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>Delete Image</title>
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
    <!-- Remember that alternative syntax is good and html inside php is bad -->
    <div id='reportcard'>
    <?php if($_POST['formStatus'] != 'deleteImg'):?>

        <h3>Failed to delete image: Cannot find image information</h3>
        <h2><a href="index.php">Go Back To Home Page</a></h2>

    <?php else: ?>
        <h2>Success</h2>
        <h3>To re-edit your game copy, <a href="show.php?item_id=<?= $_POST['item_id']?>">Click Here</a></h3>
        <h2><a href="index.php">Go Back To Home Page</a></h2>

    <?php endif ?>
    </div>
    </div>
</body>
</html>