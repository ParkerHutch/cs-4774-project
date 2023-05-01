<?php
// Replace the variables with your database information
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pokemon";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Select data from table
$sql = "SELECT * FROM pokemon";
$result = $conn->query($sql);

// Display data in a table
if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>Column 1</th><th>Column 2</th><th>Column 3</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["name"];
    }
    echo "</table>";
} else {
    echo "0 results";
}

// Close connection
$conn->close();
?>
