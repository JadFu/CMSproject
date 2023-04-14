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
    <?php if($commentStatus): ?>
        <script type='text/javascript'>alert('Comment Success: heading back to game post');</script>
        <?php header("Location: show.php?item_id=$item_id"); ?>
    <? else: ?>
        <script type='text/javascript'>alert('Comment Failed: heading back to game post');</script>
        <?php header("Location: show.php?item_id=$item_id"); ?>
    <? endif ?>
</body>
</html>
