<?php

ini_set('session.gc_maxlifetime', 18000);
session_start();
require('connect.php');


if ($_POST && !empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['info']) && isset($_POST['user_id'])) {
        // Sanitize user input to escape HTML entities and filter out dangerous characters.
        $name  = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $info = filter_input(INPUT_POST, 'info', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $user_id = filter_input(INPUT_POST, 'user_id', FILTER_SANITIZE_NUMBER_INT);
    
        
        // Build the parameterized SQL query and bind to the above sanitized values.
        $query     = "UPDATE user SET name = :name, email = :email, info = :info WHERE user_id = :user_id";
        $statement = $db->prepare($query);

        $statement->bindValue(':name', $name);        
        $statement->bindValue(':email', $email);
        $statement->bindValue(':info', $info);
        $statement->bindValue(':item_id', $item_id, PDO::PARAM_INT);
        // Execute the INSERT.
        $statement->execute(); 

    } else if (isset($_GET['user_id'])) { // Retrieve quote to be edited, if id GET parameter is in URL.

        // Sanitize the id. Like above but this time from INPUT_GET.
        $user_id = filter_input(INPUT_GET, 'user_id', FILTER_SANITIZE_NUMBER_INT);
        
        // Build the parametrized SQL query using the filtered id.
        $query = "SELECT * FROM user WHERE user_id = :user_id";
        $statement = $db->prepare($query);
        $statement->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        
        // Execute the SELECT and fetch the single row returned.
        $statement->execute();
        $rows = $statement->fetch();
    } else {

        $id = false; // False if we are not UPDATING or SELECTING.
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
        <?php if(!$_POST && filter_input(INPUT_GET, 'user_id', FILTER_VALIDATE_INT)):?>
            <form method="post" action="editUser.php">
                <fieldset>
                    <legend>Edit:</legend>
                        <input type="hidden" name="userid" value="<?= $rows['user_id'] ?>">

                        <div>
                            <label for="name">User Name</label><br>
                            <input id="name" name="name" value="<?= $rows['name'] ?>">
                            <label for="email">User E-mail</label><br>
                            <input id="email" name="email" value="<?= $rows['email'] ?>">
                        </div>

                        <div>
                            <label for="info">User Info</label><br>
                            <textarea id="info" name="info" rows="10" cols="100"><?= $rows['info'] ?></textarea>
                        </div>

                        <div id="submit">
                            <input type="submit">
                        </div>

                </fieldset>
            </form>
        <fieldset>
            <legend>Delete:</legend>
            <h2>Caution: Do Not Miss Click!</h2>
            <h3>The following button will delete this User and information cannot be restored once deleted</h3>
            <form method="post" action="deleteUser.php?user_id=<?= $rows['user_id']?>">
                <input type="hidden" name="user_id" value="<?= $rows['user_id'] ?>">
                <input type="submit" value="delete">
            </form>
        </fieldset>

        <?php elseif(!$_POST && !filter_input(INPUT_GET, 'user_id', FILTER_VALIDATE_INT)): ?>
            <h3>Invalid User ID: Cannot find User information</h3>
            <h2><a href="adminManage.php">Go Back To adminManage</a></h2>

        <?php else: ?>
            <h2>success</h2>
            <h3>Reminder: The edit will fail if any field is empty</h3>
            <h2><a href="adminManage.php">Go Back To adminManage</a></h2>
        <?php endif ?>
    </div>
</body>
</html>