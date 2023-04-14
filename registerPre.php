<?php

session_start();
require('connect.php');

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

            <form method="post" action="registerAfter.php">
                <fieldset>
                    <legend>New User Registration:</legend>

                        <input type="hidden" name="formStatus" value="register">

                        <div id="user information">
                            <label for="username">User Name:</label><br>
                            <input id="username" name="username"><br>
                            <label for="email">E-mail:</label><br>
                            <input id="email" name="email"><br>
                            <label for="userpass">Password:</label><br>
                            <input type="password" id="userpass" name="userpass"><br>
                            <label for="confirm">Confirm Password:</label><br>
                            <input type="password" id="confirm" name="confirm"><br>
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

    </div>
</body>
</html>