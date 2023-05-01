<?php include('header.php'); ?>
<html>
    <head>
    <title>View Gyms</title>
        <link rel="stylesheet" href="text-style2.css">
        <link rel="stylesheet" href="css/pokemon.css">
        <link rel="stylesheet" href="css/form.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-QpSt0Xl20MKA1Au/CpWn8lWgLv5gMlT0E3U035rZ2KLQ24dOR0U7H5Uew+5U6I+x" crossorigin="anonymous">
    </head>
   <h1>View Gyms</h1>
   
</html>
<?php

$username = 'root';
$password = '';
$host = 'localhost';           // default phpMyAdmin port = 3306
$dbname = 'pokemon';
$dsn = "mysql:host=$host;dbname=$dbname";

$loggedInTrainerId = $_SESSION["id"]; // try to get the trainer ID from the session

$loggedInTrainerID = empty($loggedInTrainerID) ? 63 : $loggedInTrainerID;

$get_trainer_sql = "SELECT trainerID, name, friendGroup FROM trainer WHERE trainerID = $loggedInTrainerId"; 
//NEW, RETURNS THE USER's GYM
$get_trainer_gym_sql = "SELECT gym_name FROM region NATURAL JOIN is_from NATURAL JOIN belongsTo WHERE trainerID = $loggedInTrainerId";

$get_trainers_sameRegion = "SELECT gym_name, name FROM trainer NATURAL JOIN belongsTo NATURAL JOIN is_from WHERE regionID = (SELECT regionID FROM is_from WHERE trainerID = $loggedInTrainerId) ORDER BY gym_name"; 


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

if (isset($_POST['gym-A-button'])) {
   $change_gym_sql = "UPDATE belongsTo SET gym_name = 'A' WHERE trainerID = $loggedInTrainerId";
   executeQuery($change_gym_sql, $dsn, $username, $password);
} else if (isset($_POST['gym-B-button'])) {
   $change_gym_sql = "UPDATE belongsTo SET gym_name = 'B' WHERE trainerID = $loggedInTrainerId";
   executeQuery($change_gym_sql, $dsn, $username, $password);
} else if (isset($_POST['gym-C-button'])) {
   $change_gym_sql = "UPDATE belongsTo SET gym_name = 'C' WHERE trainerID = $loggedInTrainerId";
   executeQuery($change_gym_sql, $dsn, $username, $password);
} else if (isset($_POST['gym-D-button'])) {
   $change_gym_sql = "UPDATE belongsTo SET gym_name = 'D' WHERE trainerID = $loggedInTrainerId";
   executeQuery($change_gym_sql, $dsn, $username, $password);
} 
try
{
   $db = new PDO($dsn, $username, $password);
      
   foreach ($db->query($get_trainer_sql) as $row) {

      echo "<h2>Hello, {$row['name']}!</h2>";
      echo "<p>Your trainer ID is {$row['trainerID']}</p>";
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


try
{
    $db = new PDO($dsn, $username, $password);
   echo "<h2>Gym</h2>";
   foreach ($db->query($get_trainer_gym_sql) as $row) {
    if(strcmp($row['gym_name'], " ") != 0){
      echo "<p>Your gym: <strong>{$row['gym_name']}</strong></p>";
    } else{
        echo "<p>You currently don't have a gym, please select a gym below</p>";
    }
   }
   echo "
      <form method='post' class='region-form'>
         <div>
            <h4>Change Gym</h4>
            <input type = 'submit' name = 'gym-A-button' value='Gym A' />
            <input type = 'submit' name = 'gym-B-button' value='Gym B' />
            <input type = 'submit' name = 'gym-C-button' value='Gym C' />
            <input type = 'submit' name = 'gym-D-button' value='Gym D' />
         </div>
      </form>
   ";
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
try{

   echo "<h2>Gym Trainers</h2>";
   echo "<table border = '1' width = '100%'>
            <thead>
               <tr>
                  <th>Gym Name</th>
                  <th>Trainer</th>
               </tr>
               </thead>
               <tbody>";
    foreach ($db->query($get_trainers_sameRegion) as $row) {  
            echo "<tr>";       
            echo "<td>{$row['gym_name']}</td>";
            echo "<td>{$row['name']}</td>";
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
