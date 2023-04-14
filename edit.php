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
    
        $statement = $db->prepare($query);
        $statementCat = $db->prepare($queryCat);
        $statementCon = $db->prepare($queryCon);

        $statement->bindValue(':item_id', $item_id, PDO::PARAM_INT);
        
        // Execute the SELECT and fetch the single row returned.
        $statement->execute();
        $statementCat->execute(); 
        $statementCon->execute();
        
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
								<option value="<?= $rowCon['console_title']?>"><?= $rowCon['console_title']?></option>
                                <?php endwhile ?>
						    </select><br>
                            <label for="categories">CATEGORIES</label><br>
                            <select id="categories" name="categories" selectedValue="<?= $rows['categories'] ?>">
                                <?php while($rowCat = $statementCat->fetch()): ?>
								<option value="<?= $rowCat['categories']?>"><?= $rowCon['info']?></option>
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
                            <textarea id="info" name="info" rows="10" cols="100" value="<?= $rows['info'] ?>"></textarea>
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
            <h2>Seems like You haven't sign in...</h2>
            <h3>Please <a href="login.php">Sign in</a> or <a href="register.php">Register</a>.</h3>
            <h2><a href="index.php">Go Back To GCH Home page</a></h2>
        <?php endif ?>
    </div>
</body>
</html>