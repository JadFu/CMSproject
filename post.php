<?php

session_start();
session_regenerate_id(true);
require('connect.php');


if ($_POST
        && !empty($_POST['user_id']) 
        && !empty($_POST['game'])
        && isset($_POST['console'])
        && isset($_POST['categories'])
        && !empty($_POST['area'])
        && isset($_POST['current_condition'])
        && !empty($_POST['info'])
        && !empty($_POST['price'])) {
    //  Sanitize user input to escape HTML entities and filter out dangerous characters.
    $user_id = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT);
    $game = filter_input(INPUT_POST, 'game', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $console = filter_input(INPUT_POST, 'console', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $categories = filter_input(INPUT_POST, 'categories', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $area = filter_input(INPUT_POST, 'area', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $current_condition = filter_input(INPUT_POST, 'current_condition', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $info = filter_input(INPUT_POST, 'info', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
    
    //  Build the parameterized SQL query and bind to the above sanitized values.
    $query = "INSERT INTO item(user_id, game, console, categories, area, current_condition, info, price) VALUES (:user_id, :game, :console, :categories, :area, :current_condition, :info, :price)";
    $statement = $db->prepare($query);
    
    //  Bind values to the parameters
    $statement->bindValue(':user_id', $user_id);
    $statement->bindValue(':game', $game);
    $statement->bindValue(':console', $console);
    $statement->bindValue(':categories', $categories);
    $statement->bindValue(':area', $area);
    $statement->bindValue(':current_condition', $current_condition);
    $statement->bindValue(':info', $info);
    $statement->bindValue(':price', $price);
    
    //  Execute the INSERT.
    //  execute() will check for possible SQL injection and remove if necessary
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
    <title>NEW ITEM POST</title>
</head>
<body>
    <!-- Remember that alternative syntax is good and html inside php is bad -->
    <div id="postcard">
        <?php if(!$_POST && isset($_SESSION['user_id'])):?>
            <form method="post" action="post.php">
                <fieldset>
                    <legend>New Post:</legend>
                        <div id="post_game">

                            <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>">

                            <label for="game">NAME OF THE GAME</label><br>
                            <input id="game" name="game"><br>
                            <label for="console">CONSOLE</label><br>
                            <select id="console" name="console">
								<option value="Nintendo Switch">Nintendo Switch</option>
								<option value="PlayStation 4">PlayStation 4</option>
								<option value="PlayStation 5">PlayStation 5</option>
								<option value="Steam Deck">Steam Deck</option>
								<option value="Xbox One">Xbox One</option>
								<option value="Xbox Series X/S">Xbox Series X/S</option>
                                <option value="others">others</option>
						    </select><br>
                            <label for="categories">CATALOG</label><br>
                            <select id="categories" name="categories">
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
            <h2>Thanks for your Submission</h2>
            <h3>Reminder: The post will fail if any area above is empty</h3>
            <h2><a href="index.php">Go Back To GCH Home page</a></h2>
        <?php endif ?>
    </div>
</body>
</html>