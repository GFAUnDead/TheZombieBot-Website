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

// Get the ID of the todo item to delete from the URL parameter
$id = $_GET['id'] ?? '';

// If the ID is not empty, delete the todo item from the database
if (!empty($id)) {
    // Delete the todo item from the database
    $sql = "DELETE FROM todo WHERE id = $id";
    mysqli_query($conn, $sql);

    // Output a success message
    $response = ['success' => 'Todo item deleted successfully'];
    echo json_encode($response);
} else {
    // If the ID is empty, output an error message
    $response = ['error' => 'Todo item ID cannot be empty'];
    echo json_encode($response);
}

// Close the database connection
mysqli_close($conn);
