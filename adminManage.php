<?php

session_start();
require('connect.php');

    
echo($_SESSION['user_id']);
echo($_SESSION['username']);
echo($_SESSION['userrole']);

    $user_id = filter_input(INPUT_GET, 'user_id', FILTER_SANITIZE_NUMBER_INT);
     // SQL is written as a String.
     $query = "SELECT * FROM user WHERE NOT user_id = :user_id";

     // A PDO::Statement is prepared from the query.
     $statement = $db->prepare($query);
     $statement->bindValue(':user_id', $user_id, PDO::PARAM_INT);
     // Execution on the DB server is delayed until we execute().

     $statement->execute(); 

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
        

        <?php while($rows = $statement->fetch()): ?>
                <div class="users">
                    <p><?= $rows['name'] ?> -<a href="editUser.php?user_id=<?= $rows['user_id']?>">edit</a></p>
                    <p><?= $rows['email'] ?></p>
                    <p><?= $rows['role'] ?></p>
                </div>
        <?php endwhile ?>


        <br><h2><a href="index.php">Go Back To Home Page</a></h2>
    </div>
</body>
</html>