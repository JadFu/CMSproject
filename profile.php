<?php

session_start();
require('connect.php');

     // SQL is written as a String.
    $user_id = $_SESSION['user_id'];

     $query = "SELECT * FROM user WHERE user_id = :user_id";

     // A PDO::Statement is prepared from the query.
     $statement = $db->prepare($query);
     $statement->bindValue(':user_id', $user_id);   

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
        <?php if(isset($_SESSION['user_id'])):?>

            <div id="userfile">

                <h2>Hi, <?= $rows['name']?></h2>

                <h3>E-mail: <?= $rows['email'] ?></h3>
                <?php $timestamp = strtotime($rows['register_date']);?>
                <h3>Register Since: <?= date("F j, Y, g:i a", $timestamp) ?></h3>
                <p>User information: <?= $rows['info'] ?></p>

                <div>
                    <ul>
                        <li><a href="changePass.php">change password</a></li>
                        <li><a href="changeInfo.php">change e-mail and user information</a></li>
                        <?php if($rows['role'] === 'admin'): ?>
                            <li><a href="adminManage.php">Manage User</a></li>
                            <li><a href="addUser.php">Add User</a></li>
                            <li><a href="addCon.php">Add console</a></li>
                            <li><a href="addCat.php">Add categories</a></li>
                        <?php endif ?>
                    </ul>
                </div>

                <h2><a href="index.php">Go Back To Home Page</a></h2>
            </div>

        <?php else: ?>
            <h3>Invalid User ID: Cannot find User information</h3>
            <h2><a href="index.php">Go Back To Home Page</a></h2>

        <?php endif ?>
    </div>

</body>
</html>