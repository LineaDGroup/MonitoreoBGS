<?php
$servername = "localhost";
$username = "dispositivo";
$password = "biodev@@2017";
$dbname = "dispositivo";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
echo "Connected OK<br>";

$log = json_encode($_GET) . json_encode($_POST);;

$sql = "INSERT INTO device (Log)
VALUES ('$log')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully<br>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
var_dump($_GET);
echo "<br>";
var_dump($log);

?>