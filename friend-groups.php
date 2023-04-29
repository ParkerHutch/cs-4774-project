<?php include('header.php'); ?>
<html>
    <head>
        <link rel="stylesheet" href="https://storage.cloud.google.com/pokeapp-pictures/css/text-style2.css">
        <link rel="stylesheet" href="https://storage.cloud.google.com/pokeapp-pictures/css/pokemon.css">
        <link rel="stylesheet" href="https://storage.cloud.google.com/pokeapp-pictures/css/form.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-QpSt0Xl20MKA1Au/CpWn8lWgLv5gMlT0E3U035rZ2KLQ24dOR0U7H5Uew+5U6I+x" crossorigin="anonymous">
    </head>
   <h1 style="text-align:center;" >Friend Groups</h1>
   <form action="all_pokemon.php" method="post">
    <div class="form-group">
    <label for="animal_name">Name:</label>
    <input class="form-control" type="text" id="group_name" name="group_name">
    </div>
     <input type="submit" />
</form>
</html>
<?php

$username = 'root';
$password = 'Tonyle1!';
$host = 'cs-4750-project-381321:us-east4:cs-4750-project';
$dbname = 'Pokemon';
$dsn = "mysql:unix_socket=/cloudsql/cs-4750-project-381321:us-east4:cs-4750-project;dbname=Pokemon";

$animal_name   = $_POST['group_name'];
$loggedInTrainerID = 200;

$friend_group_member_of_sql = "SELECT group_name FROM trainerFriendGroup WHERE trainerID = $loggedInTrainerID";
$get_friend_group_member_counts = "SELECT group_name, COUNT(*) FROM trainerFriendGroup GROUP BY group_name";

$friend_group = -1;
$num_members = 0;
$other_query = "SELECT group_name, COUNT(*) as membersCount FROM trainerFriendGroup GROUP BY group_name";

// get friend group
try
{
   $db = new PDO($dsn, $username, $password);
   foreach ($db->query($friend_group_member_of_sql) as $row) {
        $friend_group = $row["group_name"];
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
   echo "<p>$num_members member(s)</p>";
   
   if ($num_members == 1) {
      // later should delete the friend group and set the user's friend group attribute to NULL
      $button_text = "
      <form method = 'post'>
         <input type = 'submit' name = 'delete-group-button' value='Delete Friend Group' />
      </form>";
   } else {
      $button_text = "
         <form method = 'post'>
            <input type = 'submit' name = 'leave-group-button' value='Leave Friend Group' />
         </form>
      ";
   }

} else {
   $button_text = "
      <form method = 'post'>
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
                  <th>Friend Group Name</th>
                  <th># of Members</th>
                  <th>Action</th>
               </tr>
               </thead>
               <tbody>";
      foreach ($db->query($other_query) as $row2) {  
         echo "<tr>";       
         echo "<td>{$row2[group_name]}</td>";
         echo "<td>{$row2[membersCount]}</td>";
         echo "<td>
            <form method = 'post'>
               <input type = 'submit' name = 'join-group-button' value='Join Friend Group' />
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
} else {
   echo "<p>Friend group isn't -1, $friend_group</p>";
}

?>

