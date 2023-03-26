<?php
// Check if the timezone is specified in the URL
if (isset($_GET['timezone'])) {
    // Retrieve the timezone from the URL
    $timezone = $_GET['timezone'];
} else {
    // Set the default timezone to Sydney
    $timezone = 'Australia/Sydney';
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
echo "It is " . $date . ", and the time is: " . $time . " GMT" . $data['utc_offset'] . ".";
?>