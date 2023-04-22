<?php

session_start();
require('connect.php');
$queryConS = "SELECT * FROM console";
$statementConS = $db->prepare($queryConS);
$statementConS->execute();
$userAdded = false;

if ($_POST && isset($_POST['formStatus']) && $_POST['formStatus'] == 'addUser') {
    //  Sanitize user input to escape HTML entities and filter out dangerous characters.
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $userpass = $_POST['userpass'];
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $userinfo = filter_input(INPUT_POST, 'userinfo', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    
    //  Build the parameterized SQL query and bind to the above sanitized values.
        $query = "INSERT INTO USER(name, password, email, info) VALUES (:username, :userpass, :email, :userinfo)";
        $statement = $db->prepare($query);

    //  Bind values to the parameters
    $statement->bindValue(':username', $username);
    $statement->bindValue(':userpass', $userpass);
    $statement->bindValue(':email', $email);
    $statement->bindValue(':userinfo', $userinfo);
    
    //  Execute the INSERT.
    //  execute() will check for possible SQL injection and remove if necessary
    $statement->execute(); 

    $userAdded = true;
    
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>Add User</title>
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
    <div id="postcard">
        <?php if(!$userAdded): ?>
            <form method="post" action="addUser.php?">
                <fieldset>
                    <legend>Add User:</legend>

                        <input type="hidden" name="formStatus" value="addUser">

                        <div id="user information">
                            <label for="username">User Name:</label><br>
                            <input id="username" name="username"><br>
                            <label for="email">E-mail:</label><br>
                            <input id="email" name="email"><br>
                            <label for="userpass">Password:</label><br>
                            <input type="password" id="userpass" name="userpass"><br>
                        </div>

                        <div id="User Introduction">
                            <label for="userinfo">Comments</label><br>
                            <textarea id="userinfo" name="userinfo" rows="10" cols="100" placeholder="word count limit: 200"></textarea>
                        </div>

                        <div id="submit">
                            <input type="submit">
                        </div>
                </fieldset>
            </form>
        <?php else: ?>
            <div id='reportcard'>
            <h2>Success</h2>
            <h2><a href="profile.php">Go Back To profile</a></h2>
            </div>
        <?php endif ?>
    </div>
    </div>
</body>
</html>