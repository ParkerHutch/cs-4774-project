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

$pokemon_team = "-1";

$loggedInTrainerId = "63";

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

if (isset($_POST['add-to-team-button'])) {
    $add_to_team_sql = "UPDATE pokemon SET Team = $loggedInTrainerId WHERE number = $pokemon_number";
    executeQuery($add_to_team_sql, $dsn, $username, $password);
} else if (isset($_POST['remove-from-team-button'])) {
    $remove_from_team_sql = "UPDATE pokemon SET Team = NULL WHERE number = $pokemon_number";
    executeQuery($remove_from_team_sql, $dsn, $username, $password);
}

try {
    $db = new PDO($dsn, $username, $password);
    $team_sql = "SELECT Team FROM pokemon WHERE number = $pokemon_number";
    foreach ($db->query($team_sql) as $row1) {
        $pokemon_team = $row1["Team"];
    }
} catch (PDOException $e) {
   $error_message = $e->getMessage();
   echo "<p>An error occurred while connecting to the database: $error_message </p>";
} catch (Exception $e) {
   $error_message = $e->getMessage();
   echo "<p>Error message: $error_message </p>";
}

$button_text = "<p>This pokemon belongs to team $pokemon_team</p>";
if ($pokemon_team == -1 or !is_numeric($pokemon_team)) {
    $button_text = "
    <form method = 'post'>
        <input type = 'submit' name = 'add-to-team-button' value='Add to team' />
    </form>";
    //$button_text = "<button id='add_to_team_button'>Add to team</button>";
} else if ($pokemon_team == $loggedInTrainerId) {
    $button_text = "
    <form method = 'post'>
        <input type = 'submit' name = 'remove-from-team-button' value='Remove from team' />
    </form>";
    //$button_text = "<button id='remove_from_team_button'>Remove from team</button>";
}

try
{
   $db = new PDO($dsn, $username, $password);
   
   foreach ($db->query($sql) as $row) {
    echo "<h3>{$row[name]} (#{$row[number]})</h3>";
    echo $button_text;
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