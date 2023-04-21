<?php

session_start();
require('connect.php');

//find information need to display
    $queryCat = "SELECT * FROM category";
    $queryCon = "SELECT * FROM console";
    $statementCat = $db->prepare($queryCat);
    $statementCon = $db->prepare($queryCon);
    
    //  Bind values to the parameters
    
    //  Execute the INSERT.
    //  execute() will check for possible SQL injection and remove if necessary
    $statementCat->execute(); 
    $statementCon->execute();


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>NEW ITEM POST</title>
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

    <div id="postcard">
        <?php if(isset($_SESSION['user_id'])):?>
            <form method="post" action="postAfter.php">
                <fieldset>
                    <legend>New Post:</legend>

                        <div id="post_game">

                            <input type="hidden" name="formStatus" value="newPost">
                            <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>">

                            <label for="game">NAME OF THE GAME</label><br>
                            <input id="game" name="game"><br>
                            <label for="console">CONSOLE</label><br>
                            <select id="console" name="console">
                                <?php while($rowCon = $statementCon->fetch()): ?>
								<option value="<?= $rowCon['console_title']?>"><?= $rowCon['console_title']?></option>
                                <?php endwhile ?>
						    </select><br>
                            <label for="categories">CATEGORIES</label><br>
                            <select id="categories" name="categories">
                                <?php while($rowCat = $statementCat->fetch()): ?>
								<option value="<?= $rowCat['categories']?>"><?= $rowCat['info']?></option>
                                <?php endwhile ?>
						    </select><br>
                        </div>

                        <div id="post_content">
                            <label for="area">AREA</label><br>
                            <input id="area" name="area"><br>
                            <label for="current_condition">CONDITION</label><br>
                            <select id="current_condition" name="current_condition">
								<option value="NEW">NEW</option>
								<option value="USED_LIKE_NEW">USED_LIKE_NEW</option>
								<option value="USED_FAIR">USED_FAIR</option>
								<option value="USED_NOT_LOOKING_PRETTY">USED_NOT_LOOKING_PRETTY</option>
								<option value="DIGITAL_COPY_CODE">DIGITAL_COPY_CODE</option>
						    </select><br>
                            <label for="info">ITEM INFORMATION</label><br>
                            <textarea id="info" name="info" rows="10" cols="100"></textarea>
                        </div>

                        <div id="post_price">
                            <label for="price">PRICE</label><br>
                            <input id="price" name="price">
                        </div>

                        <div id="submit">
                            <input type="submit">
                        </div>
                </fieldset>
            </form>
        <?php else: ?>
            <h2>Seems like You haven't sign in...</h2>
            <h3>If you would like to post a game copy, Please <a href="login.php">Sign in</a> or <a href="register.php">Register</a>.</h3>
            <h2><a href="index.php">Go Back To GCH Home page</a></h2>
        <?php endif ?>
    </div>

    </div>
</body>
</html>