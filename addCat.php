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
    <div id="showList">
        <h2>Current Categories</h2>
        <ul>
            <li><b>Abbreviation - Full Name</b></li>
            <?php while($rowCat = $statementCat->fetch()): ?>
                <li><?= $rowCat['categories'] ?> - <?= $rowCat['info'] ?> - <a href="deleteCat.php?categories=<?= $rowCat['categories'] ?>">delete</a></li>
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
        <div id='reportcard'>
            <h2>Only Admin are allowed to use this function</h2>
            <h3>Please <a href="login.php">Sign in</a>.</h3>
            <h2><a href="index.php">Go Back To GCH Home page</a></h2>
        </div>
        <?php endif ?>
    </div>
    </div>

</body>
</html>