<?php

session_start();
require('connect.php');

if (isset($_GET['item_id'])) { 
        // Retrieve quote to be edited, if id GET parameter is in URL.
        // Sanitize the id. Like above but this time from INPUT_GET.
        $item_id = filter_input(INPUT_GET, 'item_id', FILTER_SANITIZE_NUMBER_INT);

        // Build the parametrized SQL query using the filtered id.
        $query = "SELECT * FROM ITEM WHERE item_id = :item_id";
        $queryCat = "SELECT * FROM category";
        $queryCon = "SELECT * FROM console";
        $queryImg = "SELECT * FROM image WHERE item_id = :item_id";
    
        $statement = $db->prepare($query);
        $statementCat = $db->prepare($queryCat);
        $statementCon = $db->prepare($queryCon);
        $statementImg = $db->prepare($queryImg);

        $statement->bindValue(':item_id', $item_id, PDO::PARAM_INT);
        $statementImg->bindValue(':item_id', $item_id, PDO::PARAM_INT);
        
        // Execute the SELECT and fetch the single row returned.
        $statement->execute();
        $statementCat->execute(); 
        $statementCon->execute();
        $statementImg->execute();
        
        $rows = $statement->fetch();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>Edit this Post!</title>
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
    <div id="postcard">
        <?php if(isset($_SESSION['user_id'])):?>
            <form method="post" action="update.php">
                <fieldset>
                    <legend>Edit Post:</legend>

                        <div id="post_game">

                            <input type="hidden" name="formStatus" value="updatePost">
                            <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>">
                            <input type="hidden" name="item_id" value="<?= $_GET['item_id'] ?>">

                            <label for="game">NAME OF THE GAME</label><br>
                            <input id="game" name="game" value="<?= $rows['game'] ?>"><br>
                            <label for="console">CONSOLE</label><br>
                            <select id="console" name="console" selectedValue="<?= $rows['console'] ?>">
                                <?php while($rowCon = $statementCon->fetch()): ?>
								    <option value="<?= $rowCon['console_title']?>" <?php if($rowCon['console_title'] == $rows['console']):?>selected<?php endif?>><?= $rowCon['console_title']?></option>
                                <?php endwhile ?>
						    </select><br>
                            <label for="categories">CATEGORIES</label><br>
                            <select id="categories" name="categories" selectedValue="<?= $rows['categories'] ?>">
                                <?php while($rowCat = $statementCat->fetch()): ?>
								    <option value="<?= $rowCat['categories']?>" <?php if($rowCat['categories'] == $rows['categories']):?>selected<?php endif?>><?= $rowCat['info']?></option>
                                <?php endwhile ?>
						    </select><br>
                        </div>

                        <div id="post_content">
                            <label for="area">AREA</label><br>
                            <input id="area" name="area" value="<?= $rows['area'] ?>"><br>
                            <label for="current_condition">CONDITION</label><br>
                            <select id="current_condition" name="current_condition" selectedValue="<?= $rows['current_condition'] ?>">
								<option value="NEW">NEW</option>
								<option value="USED_LIKE_NEW">USED_LIKE_NEW</option>
								<option value="USED_FAIR">USED_FAIR</option>
								<option value="USED_NOT_LOOKING_PRETTY">USED_NOT_LOOKING_PRETTY</option>
								<option value="DIGITAL_COPY_CODE">DIGITAL_COPY_CODE</option>
						    </select><br>
                            <label for="info">ITEM INFORMATION</label><br>
                            <textarea id="info" name="info" rows="10" cols="100"><?= $rows['info'] ?></textarea>
                        </div>

                        <div id="post_price">
                            <label for="price">PRICE</label><br>
                            <input id="price" name="price" value="<?= $rows['price'] ?>">
                        </div>

                        <div id="submit">
                            <input type="submit">
                        </div>
                </fieldset>
            </form>


                        <fieldset id="currentImage">
                            <legend>current images:</legend>
                            <?php while($rowImg = $statementImg->fetch()): ?>
                                <p>
                                    <form method="post" action="deleteImg.php">
                                        <input type="hidden" name="formStatus" value="deleteImg">
                                        <input type="hidden" name="item_id" value="<?= $_GET['item_id'] ?>">
                                        <input type="hidden" name="destination" value="<?= $rowImg['destination'] ?>">
                                        <input type="submit" value="delete">
                                    </form>
							        <img src="uploads/<?= $rowImg['destination'] ?>" alt="picture" width="600" height="400">
                                </p>
                            <?php endwhile ?>
                        </fieldset>


        <fieldset id="image">
            <legend>Add an image:</legend>
            <form method="post" action="updateImg.php" enctype="multipart/form-data">
                <div id="addImg">
                            <input type="hidden" name="formStatus" value="updateImg">
                            <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>">
                            <input type="hidden" name="item_id" value="<?= $_GET['item_id'] ?>">
                    <input type="file" name="file">
                    <input type="submit" value="upload">
                </div>
            </form>
        </fieldset>
        <fieldset id="delete">
            <legend>Delete:</legend>
            <h2>Caution: Do Not Miss Click!</h2>
            <h3>The following button will delete this post and information cannot be restored once deleted</h3>
            <form method="post" action="delete.php">
                <input type="hidden" name="formStatus" value="deletePost">
                <input type="hidden" name="item_id" value="<?= $rows['item_id'] ?>">
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