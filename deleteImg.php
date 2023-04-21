<?php

session_start();
require('connect.php');


if ($_POST && $_POST['formStatus'] == 'deleteImg') {
        // Sanitize user input to escape HTML entities and filter out dangerous characters.
        $destination = $_POST['destination'];
        
        // Build the parameterized SQL query and bind to the above sanitized values.
        $query = "DELETE FROM image WHERE destination = :destination";
        $statement = $db->prepare($query);

        $statement->bindValue(':destination', $destination);
        
        // Execute the INSERT.
        $statement->execute(); 

        array_map('unlink', array_filter(glob("uploads/{$destination}"), 'is_file'));
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>Delete Image</title>
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
    <div id='reportcard'>
    <?php if($_POST['formStatus'] != 'deleteImg'):?>

        <h3>Failed to delete image: Cannot find image information</h3>
        <h2><a href="index.php">Go Back To Home Page</a></h2>

    <?php else: ?>
        <h2>Success</h2>
        <h3>To re-edit your game copy, <a href="show.php?item_id=<?= $_POST['item_id']?>">Click Here</a></h3>
        <h2><a href="index.php">Go Back To Home Page</a></h2>

    <?php endif ?>
    </div>
    </div>
</body>
</html>