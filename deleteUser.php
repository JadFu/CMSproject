<?php


session_start();
session_regenerate_id(true);
require('connect.php');


if ($_POST && isset($_POST['user_id']) && filter_input(INPUT_GET, 'user_id', FILTER_VALIDATE_INT)) {
        // Sanitize user input to escape HTML entities and filter out dangerous characters.
        $user_id = filter_input(INPUT_POST, 'user_id', FILTER_SANITIZE_NUMBER_INT);
        
        // Build the parameterized SQL query and bind to the above sanitized values.
        $query     = "DELETE FROM user WHERE user_id = :user_id";
        $statement = $db->prepare($query);

        $statement->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        
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
    <?php if(!filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT)):?>

        <h3>Invalid User ID: Cannot find user information</h3>
        <h2><a href="adminManage.php">Go Back To adminManage</a></h2>

    <?php else: ?>
        <h2>Success</h2>
        <h2><a href="adminManage.php">Go Back To adminManage</a></h2>

    <?php endif ?>

</body>
</html>