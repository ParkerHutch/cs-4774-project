<?php include('header.php'); ?>
<html>
    <head>
        <link rel="stylesheet" href="https://storage.cloud.google.com/pokeapp-pictures/css/text-style2.css">
        <link rel="stylesheet" href="https://storage.cloud.google.com/pokeapp-pictures/css/pokemon.css">
        <link rel="stylesheet" href="https://storage.cloud.google.com/pokeapp-pictures/css/form.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-QpSt0Xl20MKA1Au/CpWn8lWgLv5gMlT0E3U035rZ2KLQ24dOR0U7H5Uew+5U6I+x" crossorigin="anonymous">
    </head>
   <h1 style="text-align:center;" >Message Board</h1>
    <form method = 'post'>
        <label for='create-message-text'>New Message Text:</label>
        <input class='form-control' type='text' id='create-message-text' name='create-message-text' required>
        <input type = 'submit' name = 'create-message-button' value='Post message' />
    </form>
</html>
<?php

$username = 'root';
$password = 'Tonyle1!';
$host = 'cs-4750-project-381321:us-east4:cs-4750-project';
$dbname = 'Pokemon';
$dsn = "mysql:unix_socket=/cloudsql/cs-4750-project-381321:us-east4:cs-4750-project;dbname=Pokemon";

$loggedInTrainerID = $_SESSION["id"]; // try to get the trainer ID from the session

$loggedInTrainerID = empty($loggedInTrainerID) ? 63 : $loggedInTrainerID;

echo "<p>Currently logged in trainer ID: $loggedInTrainerID</p>";

$friend_group_member_of_sql = "SELECT group_name FROM trainerFriendGroup WHERE trainerID = $loggedInTrainerID";
$get_friend_group_member_counts = "SELECT group_name, COUNT(*) FROM trainerFriendGroup GROUP BY group_name";

$friend_group = -1;
$num_members = 0;
$other_query = "SELECT group_name, COUNT(*) as membersCount FROM trainerFriendGroup GROUP BY group_name";

$delete_message_id = $_POST['delete-message-id'];
$create_message_text = $_POST['create-message-text'];


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
    echo "<p>Should delete here, query $delete_sql</p>";
} else if (!empty($create_message_text)) {
    $create_sql = "INSERT INTO messages (trainerID, messagesText) VALUES ($loggedInTrainerID, $create_message_text)";
    echo "<p>Should create here, query $create_sql</p>";
}
// if (!empty($join_group_name)) {
//    $join_sql = "UPDATE trainerFriendGroup SET group_name = '$join_group_name' WHERE trainerID = $loggedInTrainerID";
//    executeQuery($join_sql, $dsn, $username, $password);
// } else if (!empty($leave_group_name) or !empty($delete_group_name)) {
//    $join_sql = "UPDATE trainerFriendGroup SET group_name = 'NONE' WHERE trainerID = $loggedInTrainerID";
//    executeQuery($join_sql, $dsn, $username, $password);
// } 
// // else if (!empty($delete_group_name)) {
// //    echo "<p>Delete group $delete_group_name</p>";
// //    $join_sql = "UPDATE trainerFriendGroup SET group_name = 'NONE' WHERE trainerID = $loggedInTrainerID";
// //    executeQuery($join_sql, $dsn, $username, $password);
// // } 
// else if (!empty($create_group_name)) {
//    $join_sql = "UPDATE trainerFriendGroup SET group_name = '$create_group_name' WHERE trainerID = $loggedInTrainerID";
//    executeQuery($join_sql, $dsn, $username, $password);
// }


// get messages
$get_messages_sql = "SELECT messageID, trainerID, messageText FROM messages";

try
{
   $db = new PDO($dsn, $username, $password);

   echo "<table border = '1' width = '100%'>
            <thead>
               <tr>
                  <th>Trainer ID</th>
                  <th>Message</th>
                  <th>Action</th>
               </tr>
               </thead>
               <tbody>";
    foreach ($db->query($get_messages_sql) as $row) {
        //$friend_group = $row["group_name"];
        $message_trainerID = $row["trainerID"];
        echo "<tr>";
        echo "<td>$message_trainerID</td>";
        echo "<td>{$row[messageText]}</td>";
        echo "<td>
               <form method = 'post'>
                  <input type = 'submit' name = 'delete-message-button' value='Delete' />
                  <input type='hidden' id='delete-message-id' name='delete-message-id' value={$row[messageID]}>
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

?>

