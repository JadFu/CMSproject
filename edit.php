<?php

session_start();
session_regenerate_id(true);
require('connect.php');


if ($_POST 
    && !empty($_POST['item_id'])
    && !empty($_POST['game'])
    && !empty($_POST['console'])
    && !empty($_POST['main_catalog'])
    && !empty($_POST['area'])
    && !empty($_POST['current_condition'])
    && !empty($_POST['price'])) {
        // Sanitize user input to escape HTML entities and filter out dangerous characters.
        echo('1');
        $game = filter_input(INPUT_POST, 'game', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $console = filter_input(INPUT_POST, 'console', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $main_catalog = filter_input(INPUT_POST, 'main_catalog', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $area = filter_input(INPUT_POST, 'area', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $current_condition = filter_input(INPUT_POST, 'current_condition', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $info = filter_input(INPUT_POST, 'info', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
        $item_id = filter_input(INPUT_POST, 'item_id', FILTER_SANITIZE_NUMBER_INT);
    
    
    //  Build the parameterized SQL query and bind to the above sanitized values.
    $query = "UPDATE item SET game = :game, console = :console, main_catalog = :main_catalog, area = :area, current_condition = :current_condition, info = :info, price = :price WHERE item_id = :item_id";
    $statement = $db->prepare($query);
    
    //  Bind values to the parameters
    $statement->bindValue(':game', $game);
    $statement->bindValue(':console', $console);
    $statement->bindValue(':main_catalog', $main_catalog);
    $statement->bindValue(':area', $area);
    $statement->bindValue(':current_condition', $current_condition);
    $statement->bindValue(':info', $info);
    $statement->bindValue(':price', $price);
    $statement->bindValue(':item_id', $item_id, PDO::PARAM_INT);
    
    //  Execute the INSERT.
    //  execute() will check for possible SQL injection and remove if necessary
    $statement->execute(); 


    } else if (isset($_GET['item_id'])) { // Retrieve quote to be edited, if id GET parameter is in URL.
        echo("2");
        // Sanitize the id. Like above but this time from INPUT_GET.
        $item_id = filter_input(INPUT_GET, 'item_id', FILTER_SANITIZE_NUMBER_INT);
        
        // Build the parametrized SQL query using the filtered id.
        $query = "SELECT * FROM ITEM WHERE item_id = :item_id";
        $statement = $db->prepare($query);
        $statement->bindValue(':item_id', $item_id, PDO::PARAM_INT);
        
        // Execute the SELECT and fetch the single row returned.
        $statement->execute();
        $rows = $statement->fetch();

    } else {
        echo("3");
        $item_id = false; // False if we are not UPDATING or SELECTING.
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
        <?php if(!$_POST && filter_input(INPUT_GET, 'item_id', FILTER_VALIDATE_INT)):?>
            <form method="post" action="edit.php">
            <fieldset>
                    <legend>Edit Your Post:</legend>
                        <div id="post_game">

                            <input type="hidden" name="item_id" value="<?= $_GET['item_id'] ?>">

                            <label for="game">NAME OF THE GAME</label><br>
                            <input id="game" name="game" value="<?= $rows['game'] ?>"><br>
                            <label for="console">CONSOLE</label><br>
                            <select id="console" name="console" selectedValue="<?= $rows['console'] ?>">
								<option value="Nintendo Switch">Nintendo Switch</option>
								<option value="PlayStation 4">PlayStation 4</option>
								<option value="PlayStation 5">PlayStation 5</option>
								<option value="Steam Deck">Steam Deck</option>
								<option value="Xbox One">Xbox One</option>
								<option value="Xbox Series X/S">Xbox Series X/S</option>
                                <option value="others">others</option>
						    </select><br>
                            <label for="main_catalog">CATALOG</label><br>
                            <select id="main_catalog" name="main_catalog" selectedValue="<?= $rows['main_catalog'] ?>">
								<option value="BSG">Business simulation game</option>
								<option value="FPS">First-person Shooter</option>
								<option value="Horror">Horror game</option>
								<option value="Music">Music game</option>
								<option value="Rougelike">plural rougelikes</option>
								<option value="RPG">Role-play game</option>
                                <option value="RTS">Real-time Strategy</option>
                                <option value="TBS">Turn-based Strategy</option>
                                <option value="others">others</option>
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
        <fieldset>
            <legend>Delete:</legend>
            <h2>Caution: Do Not Miss Click!</h2>
            <h3>The following button will delete this post and information cannot be restored once deleted</h3>
            <form method="post" action="delete.php?id=<?= $rows['item_id']?>">
                <input type="hidden" name="item_id" value="<?= $rows['item_id'] ?>">
                <input type="submit" value="delete">
            </form>
        </fieldset>

        <?php elseif(!$_POST && !filter_input(INPUT_GET, 'item_id', FILTER_VALIDATE_INT)): ?>
            <h3>Invalid item ID: Cannot find post information</h3>
            <h2><a href="index.php">Go Back To Home Page</a></h2>

        <?php else: ?>
            <h2>Thanks for your Submission</h2>
            <h3>Reminder: The edit will fail if any field is empty</h3>
            <h2><a href="index.php">Go Back To Home Page</a></h2>

        <?php endif ?>
    </div>
</body>
</html>