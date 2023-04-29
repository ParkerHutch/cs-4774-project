<?php include('header.php'); ?>
<html>
    <head>
        <link rel="stylesheet" href="https://storage.cloud.google.com/pokeapp-pictures/css/text-style2.css">
        <link rel="stylesheet" href="https://storage.cloud.google.com/pokeapp-pictures/css/pokemon.css">
        <link rel="stylesheet" href="https://storage.cloud.google.com/pokeapp-pictures/css/form.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-QpSt0Xl20MKA1Au/CpWn8lWgLv5gMlT0E3U035rZ2KLQ24dOR0U7H5Uew+5U6I+x" crossorigin="anonymous">
    </head>
   <h1 style="text-align:center;" >View/Search/Filter Pokemon</h1>
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
$loggedInTrainerID = 2;

$friend_group_member_of_sql = "SELECT group_name FROM trainerFriendGroup WHERE trainerID = $loggedInTrainerID";

$friend_group = -1;
try
{
   $db = new PDO($dsn, $username, $password);
   
    //echo "<h2>Your friend group</h2>";
   foreach ($db->query($friend_group_member_of_sql) as $row) {
        $friend_group = $row["group_name"];
      //echo "<p>{$row[group_name]}</p>";
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

if ($friend_group != -1) {
    echo "<h2>Your friend group: $friend_group</h2>";
}

?>

