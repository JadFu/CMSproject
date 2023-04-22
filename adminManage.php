<?php

session_start();
require('connect.php');
$queryConS = "SELECT * FROM console";
$statementConS = $db->prepare($queryConS);
$statementConS->execute();
    $user_id = $_SESSION['user_id'];
     // SQL is written as a String.
     $query = "SELECT * FROM user WHERE NOT user_id = :user_id";

     // A PDO::Statement is prepared from the query.
     $statement = $db->prepare($query);

     $statement->bindValue(':user_id', $user_id);
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
    <title>Edit User</title>
</head>
<body>
<div id="container">
        <div id="header">
            <h1><a href="index.php">Graphic Card Haters</a></h1>

            <div id="searching">
                <form method="post" action="search.php">
                    <input type="hidden" name="formStatus" value="search">
                    <label for="search">Search:</label><br>
                    <input id="search" name="search"><br>
                    <label for="base">Search From</label><br>
                    <select id="base" name="base">
                        <option value="All" selected>All console</option>
                        <?php while($rowConS = $statementConS->fetch()): ?>
                            <option value="<?= $rowConS['console_title']?>"><?= $rowConS['console_title']?></option>
                        <?php endwhile ?>
					</select><br>
                    <input type="submit" value="search">
                </form>
            </div>

            <?php if(!isset($_SESSION['userrole'])): ?>
                <h3><a href="login.php">login</a>/<a href="register.php">register</a></h3>
            <?php else: ?>
                <h3><a href="profile.php">profile</a>/<a href="logout.php">logout</a></h3>
            <?php endif ?>
        </div>
    <!-- Remember that alternative syntax is good and html inside php is bad -->
    <div id="showcard">
        

        <?php while($rows = $statement->fetch()): ?>
                <div class="users">
                    <p><?= $rows['name'] ?> -<a href="editUser.php?user_id=<?= $rows['user_id']?>">edit</a></p>
                    <p><?= $rows['email'] ?></p>
                    <p><?= $rows['role'] ?></p>
                </div>
        <?php endwhile ?>


        <br><h2><a href="profile.php">Go Back To profile</a></h2>
    </div>
    </div>
</body>
</html>