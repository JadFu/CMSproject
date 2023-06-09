<?php

session_start();
require('connect.php');
$queryConS = "SELECT * FROM console";
$statementConS = $db->prepare($queryConS);
$statementConS->execute();
$postCondition = false;
$query = false;
if ($_POST && $_POST['formStatus'] == 'newPost') {
    //  Sanitize user input to escape HTML entities and filter out dangerous characters.
    $user_id = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT);
    $game = filter_input(INPUT_POST, 'game', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $console = filter_input(INPUT_POST, 'console', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $categories = filter_input(INPUT_POST, 'categories', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $area = filter_input(INPUT_POST, 'area', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $current_condition = filter_input(INPUT_POST, 'current_condition', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $info = filter_input(INPUT_POST, 'info', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
    
    //  Build the parameterized SQL query and bind to the above sanitized values.
    if(!file_exists($_FILES['file']['tmp_name']) || !is_uploaded_file($_FILES['file']['tmp_name'])){
        echo "No image has been include in the post, You could add image when editing your post later.";
        $query = "INSERT INTO item(user_id, game, console, categories, area, current_condition, info, price) VALUES (:user_id, :game, :console, :categories, :area, :current_condition, :info, :price)";
        $statement = $db->prepare($query);
    }else{
        $file = $_FILES['file'];
        $fileName = $_FILES['file']['name'];
        $fileTmpName = $_FILES['file']['tmp_name'];
        $fileSize = $_FILES['file']['size'];
        $fileError = $_FILES['file']['error'];
        $fileType = $_FILES['file']['type'];
        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));
    
        $allowed = ['jpg', 'jpeg', 'png'];
    
        if(in_array($fileActualExt, $allowed)){
            if($fileError === 0){
                    $newName = uniqid('', true).".".$fileActualExt;
                    $fileDestination = 'uploads/'.$newName;
                    move_uploaded_file($fileTmpName, $fileDestination);
    
                    $query = "INSERT INTO item(user_id, game, console, categories, area, current_condition, info, Img, price) VALUES (:user_id, :game, :console, :categories, :area, :current_condition, :info, :newName, :price)";
                    $statement = $db->prepare($query);
                    $statement->bindValue(':newName', $newName);
            }else{
                echo "There was an Error when uploading your file!";
            }
        }else{
            echo "You cannot upload file of this type!";
        }
    }
    
    //  Bind values to the parameters
    $statement->bindValue(':user_id', $user_id);
    $statement->bindValue(':game', $game);
    $statement->bindValue(':console', $console);
    $statement->bindValue(':categories', $categories);
    $statement->bindValue(':area', $area);
    $statement->bindValue(':current_condition', $current_condition);
    $statement->bindValue(':info', $info);
    $statement->bindValue(':price', $price);
    
    //  Execute the INSERT.
    //  execute() will check for possible SQL injection and remove if necessary
    if($statement->execute()){
        $postCondition = true;
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
    <title>NEW ITEM POST</title>
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
        <?php if($postCondition):?>
            <h2>Thanks for your Submission</h2>
            <h2><a href="index.php">Go Back To GCH Home page</a></h2>
        <?php else: ?>
            <h2>Your Submission Failed</h2>
            <h3>To re-post game copy, <a href="postPre.php">Click Here</a></h3>
            <h2><a href="index.php">Go Back To GCH Home page</a></h2>
        <?php endif ?>
    </div>
    </div>
</body>
</html>