
<html>
   <h1>Trainer Profile Page</h1>
   
</html>
<?php

$username = 'root';
$password = 'Tonyle1!';
$host = 'cs-4750-project-381321:us-east4:cs-4750-project';
$dbname = 'Pokemon';
$dsn = "mysql:unix_socket=/cloudsql/cs-4750-project-381321:us-east4:cs-4750-project;dbname=Pokemon";

$loggedInTrainerId = 2; // TODO replace '2' with the logged-in trainer's ID in the future
$get_trainer_sql = "SELECT trainerID, name, friendGroup FROM trainer WHERE trainerID = $loggedInTrainerId"; 
$get_trainer_region_sql = "SELECT name FROM region WHERE regionID = (SELECT regionID FROM is_from WHERE trainerID = $loggedInTrainerId)";
$get_trainer_pokemon_sql = "SELECT Name, Type1, Type2 FROM pokemon WHERE pokemon.team = (SELECT number FROM leads WHERE trainerID = $loggedInTrainerId)";
$get_trainer_friend_group = "SELECT group_name FROM trainerFriendGroup WHERE trainerID = $loggedInTrainerId";


function executeQuery($queryStatement, $dsn, $username, $password) {
   try {
      $db = new PDO($dsn, $username, $password);
      $db->query($queryStatement);
      //echo "<p>Ran query: $queryStatement</p>";
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

   echo "<p>Query: $get_trainer_sql</p>";
      
   foreach ($db->query($get_trainer_sql) as $row) {

      echo "<h2>Hello, {$row[name]}!</h2>";
      echo "<p>Your trainer ID is {$row[trainerID]}</p>";
   }
   
   echo "<h2>Region</h2>";
   foreach ($db->query($get_trainer_region_sql) as $row) {

      echo "<p>Your region: <strong>{$row[name]}</strong></p>";
   }
   echo "
      <form method='post'>
         <div>
            <h4>Change Region</h4>
            <input type = 'submit' name = 'north-button' value='North' />
            <input type = 'submit' name = 'south-button' value='South' />
            <input type = 'submit' name = 'east-button' value='East' />
            <input type = 'submit' name = 'west-button' value='West' />
         </div>
      </form>
   ";

   echo "<h2>Friend Group</h2>";
   foreach ($db->query($get_trainer_friend_group) as $row) {

      echo "<p>Your friend group: <strong>{$row[group_name]}</strong></p>";
   }

   echo "<h1>Your Pokemon</h1>";
   echo "<table>
            <thead>
               <tr>
                  <th>Name</th>
                  <th>Type1</th>
                  <th>Type2</th>
               </tr>
               </thead>
               <tbody>";
      
   foreach ($db->query($get_trainer_pokemon_sql) as $row) {
      echo "<tr>";
      echo "<td>{$row[Name]}</td>";
      echo "<td>{$row[Type1]}</td>";
      echo "<td>{$row[Type2]}</td>";
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

