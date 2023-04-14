<?php

session_start();
require('connect.php');

$editCondition = false;
if ($_POST && $_POST['formStatus'] == 'updateUser') {
        // Sanitize user input to escape HTML entities and filter out dangerous characters.
        $name  = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $password  = $_POST['password'];
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $info = filter_input(INPUT_POST, 'info', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $user_id = filter_input(INPUT_POST, 'user_id', FILTER_SANITIZE_NUMBER_INT);
    
        
        // Build the parameterized SQL query and bind to the above sanitized values.
        $query     = "UPDATE user SET name = :name, password = :password, email = :email, info = :info WHERE user_id = :user_id";
        $statement = $db->prepare($query);

        $statement->bindValue(':name', $name);
        $statement->bindValue(':password', $password);     
        $statement->bindValue(':email', $email);
        $statement->bindValue(':info', $info);
        $statement->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        // Execute the INSERT.
        if($statement->execute()){
            $editCondition = true;
        }

    } else {

        $user_id = false; // False if we are not UPDATING or SELECTING.
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>EDIT User</title>
</head>
<body>
    <!-- Remember that alternative syntax is good and html inside php is bad -->
    <div id="postcard">
        <?php if($editCondition && $_SESSION['userrole'] === 'admin'):?>
            <h2>Success</h2>
            <h2><a href="adminManage.php">Go Back To Admin Manage interface</a></h2>
            <h2><a href="index.php">Go Back To GCH Home page</a></h2>
        <?php elseif($_SESSION['userrole'] != 'admin'): ?>
            <h2>Only Admin can make this Change</h2>
            <h2><a href="index.php">Go Back To GCH Home page</a></h2>
        <?php else: ?>
            <h2>Edit Failed</h2>
            <h2><a href="adminManage.php">Go Back To Admin Manage interface</a></h2>
            <h2><a href="index.php">Go Back To GCH Home page</a></h2>
        <?php endif ?>
    </div>
</body>
</html>