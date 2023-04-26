
<html>
   <h1>View/Search Trainers</h1>
   <form action="trainers.php" method="post">
      Name: <input type="text" name="trainer_name"><br>
   <input type="submit" />
</html>
<?php

$username = 'root';
$password = 'Tonyle1!';
$host = 'cs-4750-project-381321:us-east4:cs-4750-project';
$dbname = 'Pokemon';
$dsn = "mysql:unix_socket=/cloudsql/cs-4750-project-381321:us-east4:cs-4750-project;dbname=Pokemon";

$search_name = $_POST['trainer_name'];

$sql = "SELECT trainerID, name, friendGroup FROM trainer WHERE name LIKE '%$search_name%'"; 


try
{
   $db = new PDO($dsn, $username, $password);
   
   
   
   //$type_clause = trim($pokemon_type_1) === '' ? '' : " AND (Type1 IN('$pokemon_type_1', '$pokemon_type_2') OR Type2 IN('$pokemon_type_1', '$pokemon_type_2'))";
   //$sql .= " WHERE Name LIKE '%$animal_name%'";
   //$sql .= $type_clause;
   echo "<p>Retrieved Name: $search_name</p>";
   echo "<p>Query: $sql</p>";
   echo "<table>
            <thead>
               <tr>
                  <th>TrainerID</th>
                  <th>Name</th>
                  <th>Friend Group</th>
               </tr>
               </thead>
               <tbody>";
      
   foreach ($db->query($sql) as $row) {
      echo "<tr>";
      echo "<td>{$row[trainerID]}</td>";
      echo "<td>{$row[name]}</td>";
      echo "<td>{$row[friendGroup]}</td>";
      echo "</tr>";
    //echo "<li>{$row[Name]}<li>";
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

