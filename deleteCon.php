<?php


session_start();
require('connect.php');

$deleted=false;
if ($_GET && isset($_SESSION['userrole']) && $_SESSION['userrole'] === 'admin') {
        // Sanitize user input to escape HTML entities and filter out dangerous characters.
        $console_title = $_GET['title'];
        
        // Build the parameterized SQL query and bind to the above sanitized values.
        $query     = "DELETE FROM console WHERE console_title = :console_title";
        $statement = $db->prepare($query);

        $statement->bindValue(':console_title', $console_title);
        
        // Execute the INSERT.
        if($statement->execute()){
            $deleted=true;
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
    <title>Delete</title>
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
<div id='reportcard'>
    <!-- Remember that alternative syntax is good and html inside php is bad -->
    <?php if($deleted):?>

        <h3>success</h3>
        <h2><a href="profile.php">Go Back To admin profile</a></h2>

    <?php else: ?>
        <h2>failed</h2>
        <h2><a href="profile.php">Go Back To admin profile</a></h2>

    <?php endif ?>
    </div>
    </div>
</body>
</html>