<?php

session_start();
require('connect.php');

    
echo($_SESSION['user_id']);
echo($_SESSION['username']);
echo($_SESSION['userrole']);

if ($_POST && isset($_POST['item_id']) && filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT)) {
        // Sanitize user input to escape HTML entities and filter out dangerous characters.
        $item_id = filter_input(INPUT_POST, 'item_id', FILTER_SANITIZE_NUMBER_INT);
        
        // Build the parameterized SQL query and bind to the above sanitized values.
        $query     = "DELETE FROM item WHERE item_id = :item_id";
        $statement = $db->prepare($query);

        $statement->bindValue(':item_id', $item_id, PDO::PARAM_INT);
        
        // Execute the INSERT.
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
    <title>Delete Post</title>
</head>
<body>
    <!-- Remember that alternative syntax is good and html inside php is bad -->
    <?php if(!filter_input(INPUT_POST, 'item_id', FILTER_VALIDATE_INT)):?>

        <h3>Invalid Item Post ID: Cannot find post information</h3>
        <h2><a href="index.php">Go Back To Home Page</a></h2>

    <?php else: ?>
        <h2>Success</h2>
        <h2><a href="index.php">Go Back To Home Page</a></h2>

    <?php endif ?>

</body>
</html>