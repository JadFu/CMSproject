<?php

session_start();
require('connect.php');

if (isset($_GET['user_id'])) { // Retrieve quote to be edited, if id GET parameter is in URL.

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

        $user_id = false; // False if we are not UPDATING or SELECTING.
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>Edit User</title>
</head>
<body>
    <!-- Remember that alternative syntax is good and html inside php is bad -->
    <div id="postcard">
        <?php if(isset($_SESSION['userrole']) && $_SESSION['userrole'] === 'admin'):?>
            <form method="post" action="updateUser.php">
                <fieldset>
                    <legend>Edit:</legend>

                        <input type="hidden" name="formStatus" value="updateUser">
                        <input type="hidden" name="user_id" value="<?= $rows['user_id'] ?>">

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

        <fieldset id="delete">
                <legend>Delete:</legend>
                <h2>Caution: Do Not Miss Click!</h2>
                <h3>The following button will delete this User and information cannot be restored once deleted</h3>
                <form method="post" action="deleteUser.php">
                    <input type="hidden" name="formStatus" value="deleteUser">
                    <input type="hidden" name="user_id" value="<?= $rows['user_id'] ?>">
                    <input type="submit" value="delete">
                </form>
        </fieldset>

        <?php else: ?>
            <h2>Only Admin can make this Change</h2>
            <h3>Please <a href="login.php">Sign in</a>.</h3>
            <h2><a href="index.php">Go Back To GCH Home page</a></h2>
        <?php endif ?>
    </div>
</body>
</html>