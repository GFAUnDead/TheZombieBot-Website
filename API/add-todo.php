<?php

// Define the database configuration settings
$config = [
    'host' => '(REDACTED)',
    'username' => '(REDACTED)',
    'password' => '(REDACTED)',
    'database' => '(REDACTED)'
];

// Connect to the database
$conn = mysqli_connect($config['host'], $config['username'], $config['password'], $config['database']);

// Check the database connection
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Get the channel name and todo item text from the URL parameters
$channel = $_GET['channel'] ?? '';
$text = $_GET['text'] ?? '';

// If the channel or text is empty, output an error message
if (empty($channel) || empty($text)) {
    $response = ['error' => 'Channel name and todo item text cannot be empty'];
    echo json_encode($response);
    exit;
}

// Check if the channel already exists in the database
$sql = "SELECT * FROM channels WHERE name = '$channel'";
$result = mysqli_query($conn, $sql);

// If the channel doesn't exist in the database, create a new channel
if (mysqli_num_rows($result) == 0) {
    $sql = "INSERT INTO channels (name) VALUES ('$channel')";
    mysqli_query($conn, $sql);
}

// Insert the new todo item into the database
$sql = "INSERT INTO todo (channel, text) VALUES ('$channel', '$text')";
mysqli_query($conn, $sql);

// Get the ID of the newly inserted todo item
$id = mysqli_insert_id($conn);

// Output a success message with the ID of the new todo item
$response = ['success' => 'Todo item added successfully', 'id' => $id];
echo json_encode($response);

// Close the database connection
mysqli_close($conn);
