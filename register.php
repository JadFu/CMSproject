<?php

ini_set('session.gc_maxlifetime', 18000);
session_start();
require('connect.php');

if ($_POST && !empty($_POST['username']) && !empty($_POST['userpass']) && !empty($_POST['userpass2']) && !empty($_POST['email'])) {
    //  Sanitize user input to escape HTML entities and filter out dangerous characters.
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    //$userpass = filter_input(INPUT_POST, 'userpass', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    //$userpass2 = filter_input(INPUT_POST, 'userpass2', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $userpass = $_POST['userpass'];
    $userpass2 = $_POST['userpass2'];
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $userinfo = filter_input(INPUT_POST, 'userinfo', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if(strcmp($userpass,$userpass2) === 0){
    
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

    $_SESSION['registatus'] = true;

    } elseif(strcmp($userpass,$userpass2) != 0) {

        echo('password entered does not match, please enter again');
        $_SESSION['registatus'] = false;

    }
    
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>Registration</title>
</head>
<body>
    <!-- Remember that alternative syntax is good and html inside php is bad -->
    <div id="postcard">
        <?php if(!$_POST):?>
            <form method="post" action="register.php">
                <fieldset>
                    <legend>New User Registration:</legend>
                        <div id="user information">
                            <label for="username">User Name:</label><br>
                            <input id="username" name="username"><br>
                            <label for="email">E-mail:</label><br>
                            <input id="email" name="email"><br>
                            <label for="userpass">Password:</label><br>
                            <input type="password" id="userpass" name="userpass"><br>
                            <label for="userpass2">Repeat Password:</label><br>
                            <input type="password" id="userpass2" name="userpass2"><br>
                        </div>

                        <div id="User Introduction">
                            <label for="userinfo">Content</label><br>
                            <textarea id="userinfo" name="userinfo" rows="10" cols="100" placeholder="word count limit: 200"></textarea>
                        </div>

                        <div id="submit">
                            <input type="submit">
                        </div>
                </fieldset>
            </form>
        <?php elseif(!$_SESSION['registatus']): ?>
            <h2>Registration failed</h2>
            <h3><a href="register.php" onclick="<?php session_destroy(); ?>">Click here to re-register</a></h2>
            <h3><a href="index.php" onclick="<?php session_destroy(); ?>">Click here to continue as guests</a></h2>
        <?php else: ?>
            <h2>Thanks for your Registration</h2>
            <h3>Now you can login through home page</h3>
            <h3><a href="index.php" onclick="<?php session_destroy(); ?>">Go back to home page</a></h2>
        <?php endif ?>
    </div>
</body>
</html>