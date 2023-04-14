<?php

session_start();
require('connect.php');

$editCondition = false;
if ($_POST && $_POST['formStatus'] == 'updateComment') {
    //  Sanitize user input to escape HTML entities and filter out dangerous characters.
    $item_id = filter_input(INPUT_POST, 'item_id', FILTER_SANITIZE_NUMBER_INT);
    $comment_id = filter_input(INPUT_POST, 'comment_id', FILTER_SANITIZE_NUMBER_INT);
    $comments = filter_input(INPUT_POST, 'comments', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    
    //  Build the parameterized SQL query and bind to the above sanitized values.
    $query = "UPDATE comment SET comments = :comments WHERE comment_id = :comment_id";
    $statement = $db->prepare($query);
    
    //  Bind values to the parameters
    $statement->bindValue(':comments', $comments);
    $statement->bindValue(':comment_id', $comment_id);
    
    //  Execute the INSERT.
    //  execute() will check for possible SQL injection and remove if necessary
    if($statement->execute()){
        $editCondition = true;
    }

    } else {

        $comment_id = false; // False if we are not UPDATING or SELECTING.

    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>EDIT Comment</title>
</head>
<body>
    <!-- Remember that alternative syntax is good and html inside php is bad -->
    <div id="postcard">
        <?php if($editCondition):?>
            <h2>Thanks for your Submission</h2>
            <h2><a href="show.php?item_id=<?= $item_id?>">Go Back To Post</a></h2>
            <h2><a href="index.php">Go Back To GCH Home page</a></h2>
        <?php else: ?>
            <h2>Your Submission Failed</h2>
            <h3>To re-edit your comment, <a href="editCom.php?comment_id=<?= $comment_id ?>">Click Here</a></h3>
            <h2><a href="index.php">Go Back To GCH Home page</a></h2>
        <?php endif ?>
    </div>
</body>
</html>