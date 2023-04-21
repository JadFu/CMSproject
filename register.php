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
						<option value="name">Game Name</option>
                        <option value="console">Console</option>
                        <option value="category">Category</option>
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
    </div>
</body>
</html>