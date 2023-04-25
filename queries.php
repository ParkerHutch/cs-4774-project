<?php

$username = 'root';
$password = 'Tonyle1!';     
$host = 'cs-4750-project-381321:us-east4:cs-4750-project';
$dbname = 'Pokemon';
$dsn = "mysql:unix_socket=/cloudsql/cs-4750-project-381321:us-east4:cs-4750-project;dbname=Pokemon";

try 
{
   $db = new PDO($dsn, $username, $password);
   echo "<p>You are connected to the database: $dsn</p>";
   $sql = "SELECT DISTINCT name FROM pokemon";
   foreach ($db->query($sql) as $row) {
	echo "<li>{$row['name']}<li>";
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

