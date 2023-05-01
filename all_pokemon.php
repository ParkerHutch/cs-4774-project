<?php include('header.php'); ?>
<html>
   <head>
   <title>Pokemon Search</title>
   <link rel="stylesheet" href="text-style2.css">
  <link rel="stylesheet" href="css/pokemon.css">
  <link rel="stylesheet" href="form.css">
   </head>
   <h1 style="text-align:center;" >View/Search/Filter Pokemon</h1>
   <form action="all_pokemon.php" method="POST">
  <div class="form-group">
    <label for="animal_name">Name:</label>
    <input class="form-control" type="text" id="animal_name" name="animal_name">
  </div>
  <!--
  <div class="form-group">
    <label for="animal_type">Type:</label>
    <input class="form-control" type="text" id="animal_type" name="animal_type">
  </div>
   -->
  <div class="form-group">
    <label for="pokemon_type_1">Type1:</label>
    <select class="form-control" id="pokemon_type_1" name="pokemon_type_1">
      <option value="" selected disabled hidden>--Select--</option>
      <option value="Normal">Normal</option>
      <option value="Fire">Fire</option>
      <option value="Water">Water</option>
      <option value="Grass">Grass</option>
      <option value="Electric">Electric</option>
      <option value="Ice">Ice</option>
      <option value="Fighting">Fighting</option>
      <option value="Poison">Poison</option>
      <option value="Ground">Ground</option>
      <option value="Flying">Flying</option>
      <option value="Psychic">Psychic</option>
      <option value="Bug">Bug</option>
      <option value="Rock">Rock</option>
      <option value="Ghost">Ghost</option>
      <option value="Dark">Dark</option>
      <option value="Dragon">Dragon</option>
      <option value="Steel">Steel</option>
      <option value="Fairy">Fairy</option>
    </select>
  </div>
  <div class="form-group">
    <label for="pokemon_type_2">Type2:</label>
    <select class="form-control" id="pokemon_type_2" name="pokemon_type_2">
      <option value="" selected disabled hidden>--Select--</option>
      <option value="Normal">Normal</option>
      <option value="Fire">Fire</option>
      <option value="Water">Water</option>
      <option value="Grass">Grass</option>
      <option value="Electric">Electric</option>
      <option value="Ice">Ice</option>
      <option value="Fighting">Fighting</option>
      <option value="Poison">Poison</option>
      <option value="Ground">Ground</option>
      <option value="Flying">Flying</option>
      <option value="Psychic">Psychic</option>
      <option value="Bug">Bug</option>
      <option value="Rock">Rock</option>
      <option value="Ghost">Ghost</option>
      <option value="Dark">Dark</option>
      <option value="Dragon">Dragon</option>
      <option value="Steel">Steel</option>
      <option value="Fairy">Fairy</option>
    </select>
  </div>
     <input type="submit" />
</form>
</html>
<?php
// Turn off all error reporting
 error_reporting(0);
 //var_dump($_POST);
 require_once "connect-db.php";
 $username = 'root';
 $password = '';
 $host = 'localhost';           // default phpMyAdmin port = 3306
 $dbname = 'pokemon';
 $dsn = "mysql:host=$host;dbname=$dbname";
 $db = new PDO($dsn, $username, $password);
 
if(isset($_POST['animal_type'])) {
   $animal_type = $_POST['animal_type'];
 }
 if(isset($_POST['animal_name'])) {
   $animal_name   = $_POST['animal_name'];
 }
 if(isset($_POST['animal_type'])) {
   $animal_type = $_POST['animal_type'];
 }
 if(isset($_POST['pokemon_type_1'])) {
   $pokemon_type_1 = $_POST["pokemon_type_1"];

 }
 if(isset($_POST['pokemon_type_2'])) {
   $pokemon_type_2 = $_POST["pokemon_type_2"];
 }
$sql = "SELECT name, number, Type1, Type2 FROM pokemon";

$type_clause = '';
if(!empty($pokemon_type_1) and !empty($pokemon_type_2)) {
   echo "<p>Worked</p>";
   $type_clause = " AND (Type1 IN('$pokemon_type_1', '$pokemon_type_2') OR Type2 IN('$pokemon_type_1', '$pokemon_type_2'))";
} else if (!empty($pokemon_type_1)) {
   $type_clause = " AND (Type1 IN('$pokemon_type_1') OR Type2 IN('$pokemon_type_1'))";
} else if (!empty($pokemon_type_2)) {
   $type_clause = " AND (Type1 IN('$pokemon_type_2') OR Type2 IN('$pokemon_type_2'))";
} 
try
{
   $db = new PDO($dsn, $username, $password);
   
   
   
   //$type_clause = trim($pokemon_type_1) === '' ? '' : " AND (Type1 IN('$pokemon_type_1', '$pokemon_type_2') OR Type2 IN('$pokemon_type_1', '$pokemon_type_2'))";
   $sql .= " WHERE name LIKE '%$animal_name%'";
   $sql .= $type_clause;

   
   //echo "<p>Query: $sql</p>";
   
   echo "<table border = '1' width = '100%'>
            <thead>
               <tr>
                  <th><p>Name</p></th>
                  <th><p>Type1</p></th>
                  <th><p>Type2</p></th>
               </tr>
               </thead>
               <tbody>";
      
   foreach ($db->query($sql) as $row) {
      $detail_page_link = "pokemon-detail-view.php?number={$row['number']}";
      echo "<tr>";
      echo "<td><p><a href=$detail_page_link>{$row['name']}</a></p></td>";
      echo "<td><p>{$row['Type1']}</p></td>";
      echo "<td><p>{$row['Type2']}</p></td>";
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

