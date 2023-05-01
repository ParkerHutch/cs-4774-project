<?php include('header.php'); ?>
<html>
    <head>
    <title>Friend Groups</title>
        <link rel="stylesheet" href="text-style2.css">
        <link rel="stylesheet" href="css/pokemon.css">
        <link rel="stylesheet" href="css/form.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-QpSt0Xl20MKA1Au/CpWn8lWgLv5gMlT0E3U035rZ2KLQ24dOR0U7H5Uew+5U6I+x" crossorigin="anonymous">
    </head>
   <h1 style="text-align:center;" >Friend Groups</h1>
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

$friend_group_member_of_sql = "SELECT group_name FROM trainerFriendGroup WHERE trainerID = $loggedInTrainerID";
$get_friend_group_member_counts = "SELECT group_name, COUNT(*) FROM trainerFriendGroup GROUP BY group_name";

$friend_group = -1;
$num_members = 0;
$other_query = "SELECT group_name, COUNT(*) as membersCount FROM trainerFriendGroup GROUP BY group_name";

$join_group_name = $_POST['join_group_name'];
$leave_group_name = $_POST['leave_group_name'];
$delete_group_name = $_POST['delete_group_name'];
$create_group_name = $_POST['create_group_name'];


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

if (!empty($join_group_name)) {
   $join_sql = "UPDATE trainerFriendGroup SET group_name = '$join_group_name' WHERE trainerID = $loggedInTrainerID";
   executeQuery($join_sql, $dsn, $username, $password);
} else if (!empty($leave_group_name) or !empty($delete_group_name)) {
   $join_sql = "UPDATE trainerFriendGroup SET group_name = 'NONE' WHERE trainerID = $loggedInTrainerID";
   executeQuery($join_sql, $dsn, $username, $password);
} 
// else if (!empty($delete_group_name)) {
//    echo "<p>Delete group $delete_group_name</p>";
//    $join_sql = "UPDATE trainerFriendGroup SET group_name = 'NONE' WHERE trainerID = $loggedInTrainerID";
//    executeQuery($join_sql, $dsn, $username, $password);
// } 
else if (!empty($create_group_name)) {
   $join_sql = "UPDATE trainerFriendGroup SET group_name = '$create_group_name' WHERE trainerID = $loggedInTrainerID";
   executeQuery($join_sql, $dsn, $username, $password);
}
// get friend group
try
{
   $db = new PDO($dsn, $username, $password);
   foreach ($db->query($friend_group_member_of_sql) as $row) {
        $friend_group = $row["group_name"];
        if (strcmp($friend_group, "NONE") == 0) {
         $friend_group = -1;
        }
   }
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

// get # of people in friend group
try
{
   $db = new PDO($dsn, $username, $password);

   foreach ($db->query($other_query) as $row2) {
      $extracted_group = $row2["group_name"];
      if ($friend_group != -1 and strcmp($extracted_group, $friend_group) == 0) {
         $num_members = $row2["membersCount"];
      }
   }
   
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


$button_text = "";

if ($friend_group != -1) {
   echo "<h2>Your friend group: $friend_group</h2>";
   //echo "<p>$num_members member(s)</p>";
   $button_text = "
         <form method = 'post'>
            <input type='hidden' id='leave_group_name' name='leave_group_name' value=$friend_group>
            <input type = 'submit' name = 'leave-group-button' value='Leave Friend Group' />
         </form>
      ";
   // if ($num_members == 1) {
   //    // later should delete the friend group and set the user's friend group attribute to NULL
   //    $button_text = "
   //    <form method = 'post'>
   //       <input type='hidden' id='delete_group_name' name='delete_group_name' value=$friend_group>
   //       <input type = 'submit' name = 'delete-group-button' value='Delete Friend Group' />
   //    </form>";
   // } else {
   //    $button_text = "
   //       <form method = 'post'>
   //          <input type='hidden' id='leave_group_name' name='leave_group_name' value=$friend_group>
   //          <input type = 'submit' name = 'leave-group-button' value='Leave Friend Group' />
   //       </form>
   //    ";
   // }

} else {
   echo "<p><strong>You are not currently in a friend group. Create or join one below.</strong></p>";
   $button_text = "
      <form method = 'post'>
         <h2 style='text-align:center;' >New Group Name:</h2>
         <input class='form-control' type='text' id='create_group_name' name='create_group_name'>
         <input type = 'submit' name = 'create-group-button' value='Create friend group' />
      </form>
   ";
}

echo $button_text;

// Show the available friend groups to join if the user isn't in one
if ($friend_group == -1) {
   echo "<h2>Join a friend group</h2>";

   try
   {
      $db = new PDO($dsn, $username, $password);

      echo "<table border = '1' width = '100%'>
            <thead>
               <tr>
                  <th><p>Friend Group Name</p></th>
                  <th><p># of Members</p></th>
                  <th><p>Action</p></th>
               </tr>
               </thead>
               <tbody>";
      foreach ($db->query($other_query) as $row2) {  
         if (strcmp($row2["group_name"], "NONE") != 0) {
            echo "<tr>";       
            echo "<td><p>{$row2['group_name']}</p></td>";
            echo "<td><p>{$row2['membersCount']}</p></td>";
            echo "<td>
               <form method = 'post'>
                  <input type = 'submit' name = 'join-group-button' value='Join Friend Group' />
                  <input type='hidden' id='join_group_name' name='join_group_name' value={$row2['group_name']}>
               </form>
            </td>
            ";
            echo "</tr>";
         }
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
}

?>
