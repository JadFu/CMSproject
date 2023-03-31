<?php

session_start();
session_regenerate_id(true);
require('connect.php');


    $user_id = filter_input(INPUT_GET, 'user_id', FILTER_SANITIZE_NUMBER_INT);
     // SQL is written as a String.
     $query = "SELECT * FROM user WHERE user_id = :user_id";

     // A PDO::Statement is prepared from the query.
     $statement = $db->prepare($query);
     $statement->bindValue(':user_id', $user_id, PDO::PARAM_INT);

     // Execution on the DB server is delayed until we execute().
     $statement->execute(); 

     $rows = $statement->fetch();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>POST: <?= ":id" ?></title>
</head>
<body>
    <!-- Remember that alternative syntax is good and html inside php is bad -->
    <div id="wrapper">
        <?php if(!$_POST && filter_input(INPUT_GET, 'user_id', FILTER_VALIDATE_INT)):?>

            <div id="userfile">

                <h2>Hi, <?= $rows['name']?></h2>

                <h3>E-mail: <?= $rows['email'] ?></h3>
                <?php $timestamp = strtotime($rows['register_date']);?>
                <h3>Register Since: <?= date("F j, Y, g:i a", $timestamp) ?></h3>
                <p>User information: <?= $rows['info'] ?></p>

                <form>
                    <ul>
                        <li><a href="changePass.php?user_id=<?= $rows['user_id'] ?>">change password</a></li>
                        <li><a href="changeInfo.php?user_id=<?= $rows['user_id'] ?>">change e-mail and user information</a></li>
                        <?php if($rows['role'] === 'admin'): ?>
                            <li><a href="adminManage.php?user_id=<?= $rows['user_id'] ?>">Manage User</a></li>
                        <?php endif ?>
                    </ul>
                </form>

                
            </div>

        <?php elseif(!$_POST && !filter_input(INPUT_GET, 'user_id', FILTER_VALIDATE_INT)): ?>
            <h3>Invalid User ID: Cannot find User information</h3>
            <h2><a href="index.php">Go Back To Home Page</a></h2>

        <?php endif ?>
    </div>

</body>
</html>