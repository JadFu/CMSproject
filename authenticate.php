<?php    

if ($_POST && !empty($_POST['name']) && !empty($_POST['password'])) {
  // Sanitize user input to escape HTML entities and filter out dangerous characters.
  $name  = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

     // SQL is written as a String.
     $query = "SELECT * FROM USER WHERE Name = $name";

     // A PDO::Statement is prepared from the query.
     $statement = $db->prepare($query);

     // Execution on the DB server is delayed until we execute().
     $statement->execute(); 

     $rows = $statement->fetch();

  define('USER_PASSWORD',$rows['password']);

  if ( !($pasword === USER_PASSWORD) ) {

    header('HTTP/1.1 401 Unauthorized');

    header('WWW-Authenticate: Basic realm="Post Item"');

    exit("Access Denied: Username and password required.");

  }
}

?>