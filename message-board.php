<?php include('header.php'); ?>
<html>
    <head>
    <title>Message Board</title>
        <link rel="stylesheet" href="text-style2.css">
        <link rel="stylesheet" href="css/pokemon.css">
        <link rel="stylesheet" href="css/form.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-QpSt0Xl20MKA1Au/CpWn8lWgLv5gMlT0E3U035rZ2KLQ24dOR0U7H5Uew+5U6I+x" crossorigin="anonymous">
    </head>
   <h1 style="text-align:center;" >Message Board</h1>
   <div style="display: flex; justify-content: center;">
    <form method='post' style="width: 50%;">
    <h2 style="text-align:center;" >New Message:</h2>
    <div style="display: grid; place-items: center;">
    </div>
        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name='create-message-text' style="width: 100%;"></textarea>
        <input type = 'submit' name = 'create-message-button' value='Post message' />
    </form>
</div>
</html>
<?php
// Turn off all error reporting
error_reporting(0);
$username = 'root';
$password = '';
$host = 'localhost';           // default phpMyAdmin port = 3306
$dbname = 'pokemon';
$dsn = "mysql:host=$host;dbname=$dbname";

$loggedInTrainerID = $_SESSION["id"]; // try to get the trainer ID from the session

$loggedInTrainerID = empty($loggedInTrainerID) ? 63 : $loggedInTrainerID;

echo "<p>Currently logged in trainer ID: $loggedInTrainerID</p>";

$delete_message_id = $_POST['delete-message-id'];
$create_message_text = isset($_POST['create-message-text']) ? addslashes($_POST['create-message-text']) : '';

function executeQuery($queryStatement, $dsn, $username, $password) {
   try {
      $db = new PDO($dsn, $username, $password);
      $db->query($queryStatement);
   } catch (PDOException $e)
   {
      $error_message = $e->getMessage();
      echo "<p>An error occurred while connecting to the database: $error_message </p>";
   }
   catch (Exception $e)
   {
      $error_message = $e->getMessage();
      echo "<p>Error message: $error_message </p>";
   }
}

if (!empty($delete_message_id)) {
    $delete_sql = "DELETE FROM messages WHERE messageID = $delete_message_id";
    //echo "<p>Should delete here, query $delete_sql</p>";
    executeQuery($delete_sql, $dsn, $username, $password);
} else if (!empty($create_message_text)) {
    $create_sql = "INSERT INTO messages (trainerID, messageText) VALUES ($loggedInTrainerID, '$create_message_text')";
    //echo "<p>Should create here, query $create_sql</p>";
    executeQuery($create_sql, $dsn, $username, $password);
}

// get messages
$get_messages_sql = "SELECT messageID, trainerID, messageText FROM messages";

try
{
   $db = new PDO($dsn, $username, $password);

   echo "<table border = '1' width = '100%'>
            <thead>
               <tr>
                  <th><p>Trainer ID</p></th>
                  <th><p>Message</p></th>
                  <th><p>Action</p></th>
               </tr>
               </thead>
               <tbody>";
    foreach ($db->query($get_messages_sql) as $row) {
        $message_trainerID = $row["trainerID"];
        echo "<tr>";
        echo "<td><p>$message_trainerID</p></td>";
        echo "<td><p>" . htmlspecialchars($row['messageText'], ENT_QUOTES) . "</p></td>";

        $submit_or_hidden_tag = $message_trainerID == $loggedInTrainerID ? "'submit'" : "'hidden'";
        echo "<td>
               <form method = 'post'>
                  <input type = $submit_or_hidden_tag name = 'delete-message-button' value='Delete' />
                  <input type='hidden' id='delete-message-id' name='delete-message-id' value={$row['messageID']}>
               </form>
            </td>
        ";
        echo "</tr>";
    }

      echo "</tbody>";
      echo "</table>";

   
}
catch (PDOException $e)
{
   $error_message = $e->getMessage();
   echo "<p>An error occurred while connecting to the database: $error_message </p>";
}
catch (Exception $e)
{
   $error_message = $e->getMessage();
   echo "<p>Error message: $error_message </p>";
}

