<?php include('header.php'); ?>
<html>
    <head>
    <title>Trainer Profile</title>
        <link rel="stylesheet" href="text-style2.css">
        <link rel="stylesheet" href="css/pokemon.css">
        <link rel="stylesheet" href="css/form.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-QpSt0Xl20MKA1Au/CpWn8lWgLv5gMlT0E3U035rZ2KLQ24dOR0U7H5Uew+5U6I+x" crossorigin="anonymous">
    </head>
   <h1>Trainer Profile Page</h1>
   
</html>
<?php

$username = 'root';
$password = '';
$host = 'localhost';           // default phpMyAdmin port = 3306
$dbname = 'pokemon';
$dsn = "mysql:host=$host;dbname=$dbname";

$loggedInTrainerId = $_SESSION["id"]; // TODO replace '2' with the logged-in trainer's ID in the future

$get_trainer_sql = "SELECT trainerID, name, friendGroup FROM trainer WHERE trainerID = $loggedInTrainerId"; 
$get_trainer_region_sql = "SELECT name FROM region WHERE regionID = (SELECT regionID FROM is_from WHERE trainerID = $loggedInTrainerId)";
$get_trainer_pokemon_sql = "SELECT name, Type1, Type2 FROM pokemon WHERE pokemon.team = (SELECT number FROM leads WHERE trainerID = $loggedInTrainerId)";
$get_trainer_friend_group = "SELECT group_name FROM trainerFriendGroup WHERE trainerID = $loggedInTrainerId";


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
if (isset($_POST['north-button'])) {
   $change_region_sql = "UPDATE is_from SET regionID = 1 WHERE trainerID = $loggedInTrainerId";
   executeQuery($change_region_sql, $dsn, $username, $password);
} else if (isset($_POST['south-button'])) {
   $change_region_sql = "UPDATE is_from SET regionID = 2 WHERE trainerID = $loggedInTrainerId";
   executeQuery($change_region_sql, $dsn, $username, $password);
} else if (isset($_POST['east-button'])) {
   $change_region_sql = "UPDATE is_from SET regionID = 3 WHERE trainerID = $loggedInTrainerId";
   executeQuery($change_region_sql, $dsn, $username, $password);
} else if (isset($_POST['west-button'])) {
   $change_region_sql = "UPDATE is_from SET regionID = 4 WHERE trainerID = $loggedInTrainerId";
   executeQuery($change_region_sql, $dsn, $username, $password);
} 
try
{
   $db = new PDO($dsn, $username, $password);
      
   foreach ($db->query($get_trainer_sql) as $row) {

      echo "<h2>Hello, {$row['name']}!</h2>";
      echo "<p>Your trainer ID is <strong>{$row['trainerID']}<strong></p>";
   }
   echo "
            <h2>Region:</h2>
";
   foreach ($db->query($get_trainer_region_sql) as $row) {

      echo "
      <p style='font-weight: normal;'>Your region: <strong>{$row['name']}</strong></p>";
   }
   echo "
      <form method='post' class='region-form'>
         <div>
            <h2>Change Region</h2>
            <input type = 'submit' name = 'north-button' value='North' />
            <input type = 'submit' name = 'south-button' value='South' />
            <input type = 'submit' name = 'east-button' value='East' />
            <input type = 'submit' name = 'west-button' value='West' />
         </div>
      </form>
   ";

   echo "<h2>Friend Group</h2>";
   foreach ($db->query($get_trainer_friend_group) as $row) {

      echo "<p style='font-weight: normal;'>Your friend group: <strong>{$row['group_name']}</strong></p>";
   }

   echo "<h2>Your Pokemon</h2>";
   echo "<table border = '1' width = '100%'>
            <thead>
               <tr>
                  <th><p>Name</p></th>
                  <th><p>Type1</p></th>
                  <th><p>Type2</p></th>
               </tr>
               </thead>
               <tbody>";
      
   foreach ($db->query($get_trainer_pokemon_sql) as $row) {
      echo "<tr>";
      echo "<td><p>{$row['name']}</p></td>";
      echo "<td><p>{$row['Type1']}</p></td>";
      echo "<td><p>{$row['Type2']}</p></td>";
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

