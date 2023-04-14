<?php

session_start();
require('connect.php');

//find information need to display
    $queryCat = "SELECT * FROM category";

    $statementCat = $db->prepare($queryCat);

    $statementCat->execute(); 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>NEW Category</title>
</head>
<body>
    <div id="showList">
        <h2>Current Categories</h2>
        <ul>
            <li><b>Abbreviation - Full Name</b></li>
            <?php while($rowCat = $statementCat->fetch()): ?>
                <li><?= $rowCat['categories'] ?> - <?= $rowCat['info'] ?></li>
            <?php endwhile ?>
        </ul>
    </div>

    <div id="postcard">
        
        <?php if(isset($_SESSION['userrole']) && $_SESSION['userrole'] === 'admin'):?>
            <form method="post" action="updateCat.php">
                <fieldset>
                    <legend>New Category:</legend>

                        <div id="post_game">

                            <input type="hidden" name="formStatus" value="newCat">

                            <label for="categories">Abbreviation Of the Category:</label><br>
                            <input id="categories" name="categories" placeholder="Check the Current Categories"><br>

                            <label for="info">Full Name Of the Category:</label><br>
                            <textarea id="info" name="info" rows="10" cols="100" placeholder="Check the Current Categories Above, Make sure the Abbreviation Of the Category are not duplicate!"></textarea>
                        </div>

                        <div id="submit">
                            <input type="submit">
                        </div>
                </fieldset>
            </form>
        <?php else: ?>
            <h2>Only Admin are allowed to use this function</h2>
            <h3>Please <a href="login.php">Sign in</a>.</h3>
            <h2><a href="index.php">Go Back To GCH Home page</a></h2>
        <?php endif ?>
    </div>


</body>
</html>