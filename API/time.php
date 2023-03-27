<?php
// Check if the timezone is specified in the URL
if (isset($_GET['timezone'])) {
    // Retrieve the timezone from the URL
    $timezone = $_GET['timezone'];
} else {
    // Set the default timezone to Sydney
    $timezone = 'Australia/Sydney';
}

// Check if the API key is specified in the URL
if (isset($_GET['api'])) {
    // Retrieve the API key from the URL
    $api_key = $_GET['api'];
} else {
    // Return an error message if the API key is not specified in the URL
    echo "API key is required.";
    exit();
}

// Connect to the database
$servername = "(REDACTED)";
$username = "(REDACTED)";
$password = "(REDACTED)";
$dbname = "(REDACTED)";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the connection is successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare the SQL statement to retrieve the channel name and username for the given API key
$stmt = $conn->prepare("SELECT channelname FROM allowed_users WHERE api_key = ?");
$stmt->bind_param("s", $api_key);

// Execute the SQL statement
$stmt->execute();

// Bind the result to variables
$stmt->bind_result($channelname);

// Fetch the result
$stmt->fetch();

// Close the statement
$stmt->close();

// Close the database connection
$conn->close();

// Check if the provided API key is valid and retrieve the channel name from the database
if (empty($channelname)) {
    // Return an error message if the API key is not valid
    echo "Invalid API key.";
    exit();
}

// API URL for the specified timezone
$url = "https://worldtimeapi.org/api/timezone/" . $timezone;

// Retrieve the JSON data from the API
$jsonData = file_get_contents($url);

// Convert the JSON data into a PHP array
$data = json_decode($jsonData, true);

// Set the timezone to the specified timezone
date_default_timezone_set($timezone);

// Extract the date and time from the datetime string
$date = date("l, F j, Y", strtotime($data['datetime']));
$time = date("h:i:s A", strtotime($data['datetime']));

// Display the date and time in the desired format
echo "It is " . $date . ", and the time is: " . $time . " GMT" . $data['utc_offset'] . ". ";

// Append the log data to the file
// $logFile = 'time-log.txt';
// if (file_exists($logFile) && is_writable($logFile)) {
//     file_put_contents($logFile, $logData, FILE_APPEND);
// } else {
    // Return an error message if the log file cannot be written to
//     echo "Error: Unable to write to log file.";
// }
?>
