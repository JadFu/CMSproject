<?php

session_start();
require('connect.php');

$registatus = false;

if ($_POST && $_POST['formStatus'] == 'register') {
    //  Sanitize user input to escape HTML entities and filter out dangerous characters.
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $userpass = $_POST['userpass'];
    $confirm = $_POST['confirm'];
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $userinfo = filter_input(INPUT_POST, 'userinfo', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if($userpass == $confirm){
    
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

    $registatus = true;

    } elseif ($userpass != $confirm) {

        echo("Error: Password and Confirm Password do not match");

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
        <?php if($registatus):?>
            <h2>Thanks for your Registration</h2>
            <h3>Now you can login through home page</h3>
            <h3><a href="index.php" onclick="<?php session_destroy(); ?>">Go back to home page</a></h2>
        <?php else: ?>
            <h2>Registration failed</h2>
            <h3><a href="register.php" onclick="<?php session_destroy(); ?>">Click here to re-register</a></h2>
            <h3><a href="index.php" onclick="<?php session_destroy(); ?>">Click here to continue as guests</a></h2>
        <?php endif ?>
    </div>
</body>
</html>