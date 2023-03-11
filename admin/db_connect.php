<?php
$servername = "localhost";
$username = "thezombiebot_commands";
$password = "(REDACTED)";
$dbname = "thezombiebot_commands";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>