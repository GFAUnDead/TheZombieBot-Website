<?php
// Connect to the MySQL database
$servername = "(REDACTED)";
$username = "(REDACTED)";
$password = "(REDACTED)";
$dbname = "(REDACTED)";

$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check if the channel parameter is set
if (isset($_GET['channel'])) {
    // Sanitize the input data to prevent SQL injection attacks
    $channel = mysqli_real_escape_string($conn, $_GET['channel']);
    
    // Select the todo items for the specified channel
    $sql = "SELECT * FROM todos WHERE channel = '$channel'";
    $result = mysqli_query($conn, $sql);
    
    // Display the todo list as bullet points
    if (mysqli_num_rows($result) > 0) {
      echo "<h2>$channel</h2>";
      echo "<ul>";
      while ($row = mysqli_fetch_assoc($result)) {
          echo "<li>" . htmlspecialchars($row['text']) . "</li>";
      }
      echo "</ul>";
  } else {
      echo "No todo items found for $channel";
  }
} else {
  echo "Error: channel parameter is required";
}

// Close the database connection
mysqli_close($conn);
?>