<!DOCTYPE html>
<html>
<head>
	<title>To Do List - Insert</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<link rel="icon" href="../../images/logo.png" type="image/png" />
</head>
<body>
	<header>
		<div class="header-title">
			<h1>To Do List</h1>
		</div>
		<div class="menu">
			<button onclick="location.href='../index.php'">BACK</button>
			<button onclick="location.href='index.php'">Home</button>
			<button onclick="location.href='insert.php'">New</button>
            <button onclick="location.href='update.php'">Update</button>
            <button onclick="location.href='completed.php'">Done</button>
			<button onclick="location.href='remove.php'">Delete</button>
		</div>
	</header>

    <div class="container">
        <br>
		<?php
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
            
            // Displays the user form to add tasks into the database
            echo "<h2>Add a task to your to do list:</h2>\r\n";
            echo "<form method='post' action=''>\r\n";
            echo "<label for='todo'>Your Task:</label>\r\n";
            echo "<input type='text' id='todo' name='task' required>\r\n";
            echo "<input type='submit' value='Add Task'>\r\n";
            echo "</form>";
                    
            // Connect to the database
            include('db_connect.php');
                    
            // Check if the form has been submitted
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $task = $_POST["task"];
                
                // Insert the task into the table
                $sql = "INSERT INTO todos (channel_id, todo_text) VALUES ('$channelname', '$task')";
                
                if ($conn->query($sql) === TRUE) {
                    echo "<p>The task '$task' has been added to the to do list.</p>";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
                
                // Close the database connection
                $conn->close();
            }
		?>
	</div>
</body>
</html>