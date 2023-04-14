<?php

session_start();
require('connect.php');

$editCondition = false;
if ($_POST && $_POST['formStatus'] == 'editPost') {
        // Sanitize user input to escape HTML entities and filter out dangerous characters.
        $game = filter_input(INPUT_POST, 'game', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $console = filter_input(INPUT_POST, 'console', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $calegories = filter_input(INPUT_POST, 'calegories', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $area = filter_input(INPUT_POST, 'area', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $current_condition = filter_input(INPUT_POST, 'current_condition', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $info = filter_input(INPUT_POST, 'info', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
        $item_id = filter_input(INPUT_POST, 'item_id', FILTER_SANITIZE_NUMBER_INT);
    
    
    //  Build the parameterized SQL query and bind to the above sanitized values.
    $query = "UPDATE item SET game = :game, console = :console, calegories = :calegories, area = :area, current_condition = :current_condition, info = :info, price = :price WHERE item_id = :item_id";
    $statement = $db->prepare($query);
    
    //  Bind values to the parameters
    $statement->bindValue(':game', $game);
    $statement->bindValue(':console', $console);
    $statement->bindValue(':calegories', $calegories);
    $statement->bindValue(':area', $area);
    $statement->bindValue(':current_condition', $current_condition);
    $statement->bindValue(':info', $info);
    $statement->bindValue(':price', $price);
    $statement->bindValue(':item_id', $item_id, PDO::PARAM_INT);
    
    //  Execute the INSERT.
    //  execute() will check for possible SQL injection and remove if necessary
    if($statement->execute()){
        $editCondition = true;
    }

    } else {

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
    <title>EDIT ITEM POST</title>
</head>
<body>
    <!-- Remember that alternative syntax is good and html inside php is bad -->
    <div id="postcard">
        <?php if($editCondition):?>
            <h2>Thanks for your Submission</h2>
            <h2><a href="index.php">Go Back To GCH Home page</a></h2>
        <?php else: ?>
            <h2>Your Submission Failed</h2>
            <h3>To re-edit your game copy, <a href="show.php?item_id=<?= $_POST['item_id']?>">Click Here</a></h3>
            <h2><a href="index.php">Go Back To GCH Home page</a></h2>
        <?php endif ?>
    </div>
</body>
</html>