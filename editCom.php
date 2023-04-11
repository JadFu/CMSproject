<?php

session_start();
session_regenerate_id(true);
require('connect.php');


if ($_POST
        && isset($_POST['comments'])) {
    //  Sanitize user input to escape HTML entities and filter out dangerous characters.
    $comment_id = filter_input(INPUT_GET, 'comment_id', FILTER_SANITIZE_NUMBER_INT);
    $comments = filter_input(INPUT_POST, 'comments', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    
    //  Build the parameterized SQL query and bind to the above sanitized values.
    $query = "UPDATE comment SET comments = :comments WHERE comment_id = :comment_id";
    $statement = $db->prepare($query);
    
    //  Bind values to the parameters
    $statement->bindValue(':comments', $comments);
    $statement->bindValue(':comment_id', $comment_id);
    
    //  Execute the INSERT.
    //  execute() will check for possible SQL injection and remove if necessary
    $statement->execute(); 

} else if (isset($_GET['comment_id'])) { // Retrieve quote to be edited, if id GET parameter is in URL.
        echo("2");
        // Sanitize the id. Like above but this time from INPUT_GET.
        $comment_id = filter_input(INPUT_GET, 'comment_id', FILTER_SANITIZE_NUMBER_INT);
        
        // Build the parametrized SQL query using the filtered id.
        $query = "SELECT * FROM comment WHERE comment_id = :comment_id";
        $statement = $db->prepare($query);
        $statement->bindValue(':comment_id', $comment_id, PDO::PARAM_INT);
        
        // Execute the SELECT and fetch the single row returned.
        $statement->execute();
        $rows = $statement->fetch();

    } else {
        echo("3");
        $item_id = false; // False if we are not UPDATING or SELECTING.
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>Edit this Post!</title>
</head>
<body>
    <!-- Remember that alternative syntax is good and html inside php is bad -->
    <div id="postcard">
        <?php if(!$_POST && !isset($_POST['comments'])):?>
            <form method="post" action="editCom.php?comment_id=<?= $_GET['comment_id']?>">

                        <label for="comments">post comments</label><br>
                        <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

                        
                        <script>
                        tinymce.init({
                            selector: '#comments',
                            plugins: [
                            'a11ychecker','advlist','advcode','advtable','autolink','checklist','export',
                            'lists','link','image','charmap','preview','anchor','searchreplace','visualblocks',
                            'powerpaste','fullscreen','formatpainter','insertdatetime','media','table','help','wordcount'
                            ],
                            toolbar: 'undo redo | formatpainter casechange blocks | bold italic backcolor | ' +
                            'alignleft aligncenter alignright alignjustify | ' +
                            'bullist numlist checklist outdent indent | removeformat | a11ycheck code table help'
                        });
                        </script>

                        <textarea id="comments" name="comments" rows="10" cols="100"><?= $rows['comments'] ?></textarea>

                        <input type="submit">
                    </form>

        <?php elseif(!$_POST && !filter_input(INPUT_GET, 'comment_id', FILTER_VALIDATE_INT)): ?>
            <h3>Invalid item ID: Cannot find post information</h3>
            <h2><a href="index.php">Go Back To Home Page</a></h2>

        <?php else: ?>
            <h2>Thanks for your Submission</h2>
            <h3>Reminder: The edit will fail if any field is empty</h3>
            <h2><a href="index.php">Go Back To Home Page</a></h2>

        <?php endif ?>
    </div>
</body>
</html>