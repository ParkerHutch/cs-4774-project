
<html>
   <h1>Trainer Profile Page</h1>
   <form action="trainer_profile.php" method="post">
      Name: <input type="text" name="animal_name"><br>
   <input type="submit" />
</html>
<?php

$username = 'root';
$password = 'Tonyle1!';
$host = 'cs-4750-project-381321:us-east4:cs-4750-project';
$dbname = 'Pokemon';
$dsn = "mysql:unix_socket=/cloudsql/cs-4750-project-381321:us-east4:cs-4750-project;dbname=Pokemon";

// TODO replace '2' in each line below with the logged-in trainer's ID in the future
$get_trainer_sql = "SELECT trainerID, name, friendGroup FROM trainer WHERE trainerID = 2"; 
$get_trainer_region_sql = "SELECT name FROM region WHERE regionID = (SELECT regionID FROM is_from WHERE trainerID = 2)";
$get_trainer_pokemon_sql = "SELECT * FROM pokemon WHERE pokemon.team = (SELECT number FROM leads WHERE trainerID = 2)";

try
{
   $db = new PDO($dsn, $username, $password);

   echo "<p>Query: $get_trainer_sql</p>";
      
   foreach ($db->query($get_trainer_sql) as $row) {

      echo "<h2>Hello, {$row[name]}!</h2>";
      echo "<p>Your trainer ID is {$row[trainerID]}</p>";
   }
   
   foreach ($db->query($get_trainer_region_sql) as $row) {

      echo "<p>Your region is {$row[name]}</p>";
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

?>

