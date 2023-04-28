<?php include('header.php'); ?>
<html>
    <head>
        <link rel="stylesheet" href="https://storage.cloud.google.com/pokeapp-pictures/css/text-style2.css">
        <link rel="stylesheet" href="https://storage.cloud.google.com/pokeapp-pictures/css/pokemon.css">
        <link rel="stylesheet" href="https://storage.cloud.google.com/pokeapp-pictures/css/form.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-QpSt0Xl20MKA1Au/CpWn8lWgLv5gMlT0E3U035rZ2KLQ24dOR0U7H5Uew+5U6I+x" crossorigin="anonymous">
    </head>
   
   <h1>Pokemon Detail View</h1>
</html>

<?php

$username = 'root';
$password = 'Tonyle1!';
$host = 'cs-4750-project-381321:us-east4:cs-4750-project';
$dbname = 'Pokemon';
$dsn = "mysql:unix_socket=/cloudsql/cs-4750-project-381321:us-east4:cs-4750-project;dbname=Pokemon";

$pokemon_number = 1;

$uri = $_SERVER['REQUEST_URI'];

$url_components = parse_url($uri);
 
parse_str($url_components['query'], $params);
    
$pokemon_number = $params['number'];

$pokemon_number = is_numeric($pokemon_number) ? $pokemon_number : 1;

$sql = "SELECT number, name, Type1, Type2, Total, HP, Attack, Defense, SpAtk, SpDef, Speed, Generation, Legendary, Team FROM pokemon WHERE number = $pokemon_number";

try
{
   $db = new PDO($dsn, $username, $password);
   
   foreach ($db->query($sql) as $row) {
    echo "<h3>{$row[name]} (#{$row[number]})</h3>";
    echo "
    <table border = '1' width = '100%'>
        <thead>
            <tr>
                <th>Attribute</th>
                <th>Value</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Type1</td>
                <td>{$row[Type1]}</td>
            </tr>
            <tr>
                <td>Type2</td>
                <td>{$row[Type2]}</td>
            </tr>
            <tr>
                <td>Total</td>
                <td>{$row[Total]}</td>
            </tr>
            <tr>
                <td>HP</td>
                <td>{$row[HP]}</td>
            </tr>
            <tr>
                <td>Attack</td>
                <td>{$row[Attack]}</td>
            </tr>
            <tr>
                <td>Defense</td>
                <td>{$row[Defense]}</td>
            </tr>
            <tr>
                <td>SpAtk</td>
                <td>{$row[SpAtk]}</td>
            </tr>
            <tr>
                <td>SpDef</td>
                <td>{$row[SpDef]}</td>
            </tr>
            <tr>
                <td>Speed</td>
                <td>{$row[Speed]}</td>
            </tr>
            <tr>
                <td>Generation</td>
                <td>{$row[Generation]}</td>
            </tr>
            <tr>
                <td>Legendary</td>
                <td>{$row[Legendary]}</td>
            </tr>
            <tr>
                <td>Team</td>
                <td>{$row[Team]}</td>
            </tr>
        </tbody>
    </table>
      ";
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