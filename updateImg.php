<?php

session_start();
require('connect.php');

$editCondition = false;
if ($_POST && $_POST['formStatus'] == 'updateImg') {
    if(!file_exists($_FILES['file']['tmp_name']) || !is_uploaded_file($_FILES['file']['tmp_name'])){
        echo "No image has been include in the post, You could add image when editing your post later.";
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
    
                    echo "uploading image into database: in progress....";
                    $item_id = filter_input(INPUT_POST, 'item_id', FILTER_SANITIZE_NUMBER_INT);

                    $queryImg = "INSERT INTO image (destination, item_id) VALUES (:newName, :item_id)";
    
                    $statementImg = $db->prepare($queryImg);
    
                    $statementImg->bindValue(':newName', $newName);
                    $statementImg->bindValue(':item_id', $item_id);
    
                                if($statementImg->execute()){
                                    echo "image upload success!";
                                    $editCondition = true;
                                }
        
            }else{
                echo "There was an Error when uploading your file!";
            }
        }else{
            echo "You cannot upload file of this type!";
        }
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
    <title>EDIT ITEM POST</title>
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
        <?php if($editCondition):?>
            <h2>Thanks for your Submission</h2>
            <h2><a href="index.php">Go Back To GCH Home page</a></h2>
        <?php else: ?>
            <h2>Your Submission Failed</h2>
            <h3>To re-edit your game copy, <a href="show.php?item_id=<?= $_POST['item_id']?>">Click Here</a></h3>
            <h2><a href="index.php">Go Back To GCH Home page</a></h2>
        <?php endif ?>
    </div>
    </div>
</body>
</html>