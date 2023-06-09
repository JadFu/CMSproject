<?php

session_start();
require('connect.php');

$queryConS = "SELECT * FROM console";
$statementConS = $db->prepare($queryConS);
$statementConS->execute();

if ($_POST && isset($_POST['username']) && isset($_POST['userpass'])) {
  // Sanitize user input to escape HTML entities and filter out dangerous characters.
  $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $userpass = $_POST['userpass'];

     // SQL is written as a String.
     $query = "SELECT * FROM USER WHERE name = :username AND password = :userpass";

     // A PDO::Statement is prepared from the query.
     $statement = $db->prepare($query);

     $statement->bindValue(':username', $username);        
     $statement->bindValue(':userpass', $userpass);

     // Execution on the DB server is delayed until we execute().
     $statement->execute(); 

if($rows = $statement->fetch()){

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
  <link rel="stylesheet" href="main.css">
  <title>User Login</title>
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
  <?php if(!isset($_SESSION['userrole'])): ?>
    <div id="login">
      <form action="login.php" method="post">
        <label for="username">USER NAME</label>
        <input name="username" id="username" required>
        <label for="userpass">USER PASSWORD</label>
        <input name="userpass" id="userpass" type="password" required>
        <input type="submit" value="Login">
      </form>
    </div>
    <?php else: ?>
      <h2>Thank You for Using Graphic Card Haters, <?= $_SESSION['userrole'] ?> <?= $_SESSION['username'] ?></h2>
      <h3><a href="index.php">click here to go back to home page!</a></h3>
    <?php endif ?>
    </div>
</body>
</html>