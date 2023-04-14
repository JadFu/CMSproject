<?php

session_start();
require('connect.php');

//find information need to display
    $queryCon = "SELECT * FROM console";

    $statementCon = $db->prepare($queryCon);

    $statementCon->execute(); 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" Content="IE=edge">
    <meta name="viewport" Content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>NEW Console</title>
</head>
<body>
    <div id="showList">
        <h2>Current Console_title</h2>
        <ul>
            <li><b>Console Name</b></li>
            <?php while($rowCon = $statementCon->fetch()): ?>
                <li><?= $rowCon['console_title'] ?></li>
            <?php endwhile ?>
        </ul>
    </div>

    <div id="postcard">
        
        <?php if(isset($_SESSION['userrole']) && $_SESSION['userrole'] === 'admin'):?>
            <form method="post" action="updateCon.php">
                <fieldset>
                    <legend>New Console:</legend>

                        <div id="post_game">

                            <input type="hidden" name="formStatus" value="newCon">

                            <label for="console_title">Console Name:</label><br>
                            <input id="console_title" name="console_title" placeholder="Check the Current Console_title"><br>

                            <label for="info">Console information</label><br>
                            <textarea id="info" name="info" rows="10" cols="100" placeholder="Check the Current Console_title Above, Make sure the Console_title are not duplicate!"></textarea>
                        </div>

                        <div id="submit">
                            <input type="submit">
                        </div>
                </fieldset>
            </form>
        <?php else: ?>
            <h2>Only Admin are allowed to use this function</h2>
            <h3>Please <a href="login.php">Sign in</a>.</h3>
            <h2><a href="index.php">Go Back To GCH Home page</a></h2>
        <?php endif ?>
    </div>


</body>
</html>