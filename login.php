<?php

session_start();
ini_set('session.gc_maxlifetime', 18000);
require('connect.php');

if ($_POST && !empty($_POST['username']) && !empty($_POST['userpass'])) {
  // Sanitize user input to escape HTML entities and filter out dangerous characters.
  $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $userpass = filter_input(INPUT_POST, 'userpass', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

     // SQL is written as a String.
     echo($_POST['username']);
     echo($_POST['userpass']);
     $query = "SELECT * FROM USER WHERE name = :username AND password = :userpass";

     // A PDO::Statement is prepared from the query.
     $statement = $db->prepare($query);

     $statement->bindValue(':username', $username);        
     $statement->bindValue(':userpass', $userpass);

     // Execution on the DB server is delayed until we execute().
     $statement->execute(); 

     $rows = $statement->fetch();

if(strcmp($rows['name'],$username) === 0 && strcmp($rows['password'],$userpass) === 0){
  $_SESSION['user_id'] = $rows['user_id'];
  $_SESSION['username'] = $username;
  $_SESSION['userrole'] = $rows['role'];
} else {
  echo "Invalid username or password.";
}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Login</title>
</head>
<body>
  <?php if(!isset($_SESSION['userrole'])): ?>
    <div class="login">
      <form action="login.php" method="post">
        <label for="username">USER NAME</label>
        <input name="username" id="username" required>
        <label for="userpass">USER PASSWORD</label>
        <input name="userpass" id="userpass" required>
        <input type="submit" value="Login">
      </form>
    </div>
    <?php else: ?>
      <h2>Thank You for Using Graphic Card Haters, <?= $_SESSION['userrole'] ?><?= $_SESSION['username'] ?></h2>
      <h3><a href="index.php">click here to go back to home page!</a></h3>
    <?php endif ?>
</body>
</html>